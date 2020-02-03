<?php

namespace bw\ContactBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $name;

    /**
     * @Assert\Email()
     * @var string
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $phone;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Contact
     */
    public function setName(string $name): Contact
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Contact
     */
    public function setEmail(string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Contact
     */
    public function setMessage(string $message): Contact
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Contact
     */
    public function setPhone(string $phone): Contact
    {
        $this->phone = $phone;
        return $this;
    }

    public function __toString()
    {
        return sprintf(
            "email : %s, name : %s, phone : %s, message : %s",
            $this->email,
            $this->name,
            $this->phone,
            $this->message
        );

    }
}