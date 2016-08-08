<?php

namespace User\Form;

use User\Entity\Hydrator\ProjectHydrator;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class ProjectForm extends Form
{
    public function __construct()
    {
        parent::__construct('project-form');
        $hydrator = new AggregateHydrator();
       // $hydrator->add(new AuthorHydrator());
        $hydrator->add(new ProjectHydrator());
        $this->setHydrator($hydrator);

        
        $id = new Element\Hidden('id');
        
        $project_name = new Element\Text('project_name');
        $project_name->setLabel('Nombre de proyecto');
        $project_name->setAttribute('class', 'form-control');

        $abstract = new Element\Text('abstract');
        $abstract->setLabel('Resumen');
        $abstract->setAttribute('class', 'form-control');

        
        $webpage = new Element\Text('webpage');
        $webpage->setLabel('Página Web');
        $webpage->setAttribute('class', 'form-control');

        $project_type= new Element\Select('project_type');
        $project_type->setLabel('Tipo de proyecto');
        $project_type->setAttribute('class', 'input-field');
        $project_type->setValueOptions(array(
            'productivos' => 'Proyectos productivos', 
            'educativos' => 'Proyectos educativos',
            'sociales' => 'Proyectos sociales',
            'comunitarios' => 'Proyectos comunitarios',
            'investigación' => 'Proyectos de investigación',
        ));

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
        $this->add($project_name);
        $this->add($abstract);
        $this->add($webpage);
        $this->add($project_type);
        $this->add($startDate);
        $this->add($endDate);
        $this->add($submit);
    }
} 