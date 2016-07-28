<?php

namespace User\Form;

use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;

class AddEducation extends \Zend\Form\Form
{
    public function __construct()
    {
        parent::__construct('add-education');
        $this->setHydrator(new ClassMethods());

        $firstName = new Element\Text('firstName');
        $firstName->setLabel('Nombre(s)');
        $firstName->setAttribute('class', 'form-control');

        $lastName = new Element\Text('lastName');
        $lastName->setLabel('Apellido');
        $lastName->setAttribute('class', 'form-control');
        
        $gender = new Element\Select('gender');
        $gender->setLabel('Género');
        $gender->setAttribute('class', 'input-field');
        $gender->setValueOptions(array(
            1 => 'Femenino',
            0 => 'Masculino',
        ));
        
        $nickName = new Element\Text('nickname');
        $nickName->setLabel('Nombre de usuario');
        $nickName->setAttribute('class', 'form-control');

        $email = new Element\Email('email');
        $email->setLabel('Correo electrónico');
        $email->setAttribute('class', 'form-control');

        $password = new Element\Password('password');
        $password->setLabel('Contraseña');
        $password->setAttribute('class', 'form-control');

        $repeatPassword = new Element\Password('repeatPassword');
        $repeatPassword->setLabel('Repetir contraseña');
        $repeatPassword->setAttribute('class', 'form-control');

        $submit = new Element\Submit('submit');
        $submit->setValue('Abrir una cuenta');
        $submit->setAttribute('class', 'btn btn-primary');

        $this->add($firstName);
        $this->add($lastName);
        $this->add($gender);
        $this->add($nickName);
        $this->add($email);
        $this->add($password);
        $this->add($repeatPassword);
        $this->add($submit);
    }
} 