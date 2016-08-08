<?php

namespace User\Form;

use User\Entity\Hydrator\DegreeHydrator;
use User\Entity\Hydrator\EducationHydrator;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class EditEducation extends Form
{
    public function __construct()
    {
        parent::__construct('edit-education');
        
        $hydrator = new AggregateHydrator();
        $hydrator->add(new DegreeHydrator());
        $hydrator->add(new EducationHydrator());
        $this->setHydrator($hydrator);

        
        $id = new Element\Hidden('id');
        
        $organization = new Element\Text('organization');
        $organization->setLabel('Institución');
        $organization->setAttribute('class', 'form-control');
        
        $degree = new Element\Select('degree_id');
        $degree->setLabel('Grado');
        $degree->setAttribute('class', 'input-field');
        $degree->setValueOptions(array(
            1 => 'Preescolar', 
            2 => 'Primaria',
            3 => 'Secundaria',
            4 => 'Preparatoria',
            5 => 'Bachillerato',
            6 => 'Diplomado',
            7 => 'Técnico',
            8 => 'Licenciatura',
            9 => 'Ingeniería',
            10 => 'Posgrado',
        ));

        $career = new Element\Text('career');
        $career->setLabel('Carrera');
        $career->setAttribute('class', 'form-control');

        
        $academicSpecialty = new Element\Text('academic_specialty');
        $academicSpecialty->setLabel('Especialidad');
        $academicSpecialty->setAttribute('class', 'form-control');

        $academicAchievement = new Element\Text('academic_achievement');
        $academicAchievement->setLabel('Logros en la carrera');
        $academicAchievement->setAttribute('class', 'form-control');
        
        

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
        $submit->setValue('Agregar educación');
        $submit->setAttribute('class', 'btn btn-primary');

        $this->add($id);
        $this->add($organization);
        $this->add($degree);
        $this->add($career);
        $this->add($academicSpecialty);
        $this->add($academicAchievement);
        $this->add($startDate);
        $this->add($endDate);
        $this->add($submit);
    }
} 