<?php

namespace User\Form;

use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;

class Add extends \Zend\Form\Form
{
    public function __construct()
    {
        parent::__construct('add-user');
        $this->setHydrator(new ClassMethods());

        $firstName = new Element\Text('firstName');
        $firstName->setLabel('First name');
        $firstName->setAttribute('class', 'form-control');

        $lastName = new Element\Text('lastName');
        $lastName->setLabel('Last name');
        $lastName->setAttribute('class', 'form-control');

        $email = new Element\Email('email');
        $email->setLabel('E-mail address');
        $email->setAttribute('class', 'form-control');

        $password = new Element\Password('password');
        $password->setLabel('Password');
        $password->setAttribute('class', 'form-control');

        $repeatPassword = new Element\Password('repeatPassword');
        $repeatPassword->setLabel('Repeat password');
        $repeatPassword->setAttribute('class', 'form-control');

        $submit = new Element\Submit('submit');
        $submit->setValue('Add User');
        $submit->setAttribute('class', 'btn btn-primary');

        $this->add($firstName);
        $this->add($lastName);
        $this->add($email);
        $this->add($password);
        $this->add($repeatPassword);
        $this->add($submit);
    }
} 