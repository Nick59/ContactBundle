<?php

namespace bw\ContactBundle\Service;


use bw\ContactBundle\Form\ContactForm;
use bw\ContactBundle\Model\Contact;
use Symfony\Component\Form\FormFactoryInterface;
use Twig\Template;

class ContactService
{
    /** @var FormFactoryInterface  */
    private $formBuilder;

    /** @var \Swift_Mailer  */
    private $mailer;

    /** @var string */
    private $recipient;

    /** @var \Twig_Environment */
    private $template;

    public function __construct(FormFactoryInterface $formBuilder, \Swift_Mailer $mailer, \Twig_Environment $template, $recipient)
    {
        $this->formBuilder = $formBuilder;
        $this->mailer = $mailer;
        $this->recipient = $recipient;
        $this->template = $template;
    }


    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getForm(Contact $contact, $route)
    {
        $form = $this->formBuilder->create(ContactForm::class, $contact, [
            'action' => $route
        ]);

        return $form;
    }

    public function sendMail(Contact $contact)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom($contact->getEmail())
            ->setTo($this->recipient)
            ->setBody($this->template->render('@Contact/Email/contact.html.twig', array('contact' => $contact)),
                'text/html'
            )
        ;

        $this->mailer->send($message);

    }

}