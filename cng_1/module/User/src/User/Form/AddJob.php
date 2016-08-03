<?php

namespace User\Form;

use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;

class AddJob extends \Zend\Form\Form
{
    public function __construct()
    {
        parent::__construct('add-job');
        $this->setHydrator(new ClassMethods());

        
        $id = new Element\Hidden('id');
        $user_id = new Element\Hidden('id');
        
        $organization = new Element\Text('organization');
        $organization->setLabel('Institución');
        $organization->setAttribute('class', 'form-control');

        $position = new Element\Text('position');
        $position->setLabel('Puesto');
        $position->setAttribute('class', 'form-control');

        
        $jobDescription = new Element\Text('job_description');
        $jobDescription->setLabel('Descripción del puesto');
        $jobDescription->setAttribute('class', 'form-control');

        $jobAchievement = new Element\Text('job_achievement');
        $jobAchievement->setLabel('Logros en el puesto');
        $jobAchievement->setAttribute('class', 'form-control');

        $startDate = new Element\Date('start_date');
        $startDate->setLabel('Fecha de inicio');
        $startDate->setAttributes(array(
               // 'min'  => '1960-01-01',
                //'max'  => '2020-01-01', //cambiar a dia actual
                'step' => '1', 
                'class'=>'datepicker',
            ));
        $startDate->setOptions(array('format' => 'Y-m-d'));
        
        $endDate = new Element\Date('end_date');
        $endDate->setLabel('Fecha de fin');
        $endDate->setAttributes(array(
                //'min'  => '1960-01-01',
                //'max'  => '2020-01-01', //cambiar a dia actual
                'step' => '1',
                'class'=>'datepicker',
            ));
        $endDate->setOptions(array('format' => 'Y-m-d'));


        $submit = new Element\Submit('submit');
        $submit->setValue('Agregar trabajo');
        $submit->setAttribute('class', 'btn btn-primary');

        $this->add($id);
        $this->add($user_id);
        $this->add($organization);
        $this->add($position);
        $this->add($jobDescription);
        $this->add($jobAchievement);
        $this->add($startDate);
        $this->add($endDate);
        $this->add($submit);
    }
} 