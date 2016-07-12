<?php

namespace User\Form;

use Zend\Form\Element;

class Login extends \Zend\Form\Form
{
    public function __construct()
    {
        parent::__construct('login');

        $email = new Element\Text('email');
        $email->setLabel('Correo electrónico');
        $email->setAttributes(array(
            'class' => 'input-field col s12',
        ));

        $password = new Element\Password('password');
        $password->setLabel('Contraseña');
        $password->setAttributes(array(
            'class' => 'input-field col s12',
        ));

        $submit = new Element\Submit('submit');
        $submit->setValue('Iniciar sesión');
        $submit->setAttribute('class', 'btn waves-effect waves-light btn');

        $this->add($email);
        $this->add($password);
        $this->add($submit);
    }
} 