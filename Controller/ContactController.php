<?php

namespace bw\ContactBundle\Controller;

use bw\ContactBundle\Model\Contact;
use bw\ContactBundle\Service\ContactService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Translator;

/**
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * @Route("/", name="contact_index")
     */
    public function showFormAction()
    {
        $contactService = $this->get(contactService::class);
        $contact = new Contact();


        $route = $this->generateUrl('contact_send_mail');
        $form = $contactService->getForm($contact, $route);

        return $this->render(
            'ContactBundle:Default:index.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/send_mail", name="contact_send_mail")
     */
    public function sendMailAction(Request $request)
    {
        $contact = new Contact();
        $translator = $this->get('translator');
        $logger = $this->get('logger');
        $contactService = $this->get(contactService::class);

        $form = $contactService->getForm($contact, '');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $contactService->sendMail($contact);
                $logger->info(sprintf('sending email : %s', $contact));
                $this->addFlash('success', $translator->trans('contact.sending_success'));

            } catch (\Exception $e) {
                $logger->error(sprintf('Error while sending email. %s %s', $e->getMessage(), $contact));
                $this->addFlash('error', $translator->trans('contact.sending_failed'));
            }
        }

        return $this->redirect($this->generateUrl('homepage').'#contactarea');
    }
}
