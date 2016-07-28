<?php

namespace User\Form;

use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;

class Edit extends \Zend\Form\Form
{
    public function __construct()
    {
        parent::__construct('edit-user');
        $this->setHydrator(new ClassMethods());

        $id = new Element\Hidden('id');
        
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
        
        $age = new Element\Text('age');
        $age->setLabel('Edad');
        $age->setAttribute('class', 'form-control');
        
        $bio = new Element\Text('bio');
        $bio->setLabel('Biografía');
        $bio->setAttribute('class', 'form-control');

        $submit = new Element\Submit('submit');
        $submit->setValue('Guardar');
        $submit->setAttribute('class', 'btn btn-primary');

        $this->add($id);
        $this->add($firstName);
        $this->add($lastName);
        $this->add($gender);
        $this->add($age);
        $this->add($bio);
        $this->add($submit);
    }
} 