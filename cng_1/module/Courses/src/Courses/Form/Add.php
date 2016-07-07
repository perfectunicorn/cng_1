<?php

namespace Courses\Form;

use Courses\Entity\Hydrator\CategoryHydrator;
use Courses\Entity\Hydrator\CourseHydrator;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class Add extends Form
{
    public function __construct()
    {
        parent::__construct('add');

        $hydrator = new AggregateHydrator();
        $hydrator->add(new CourseHydrator());
        $hydrator->add(new CategoryHydrator());
        $this->setHydrator($hydrator);

        $title = new Element\Text('title');
        $title->setLabel('Title');
        $title->setAttribute('class', 'form-control');

        $goal = new Element\Text('goal');
        $goal->setLabel('Objetivo');
        $goal->setAttribute('class', 'form-control');

        $description = new Element\Textarea('description');
        $description->setLabel('Descripción');
        $description->setAttribute('class', 'form-control');

        $category = new Element\Select('category_id');
        $category->setLabel('Category');
        $category->setAttribute('class', 'form-control');
        $category->setValueOptions(array(
            1 => 'Zend Framework',
            2 => 'PHP',
            3 => 'MySQL',
        ));

        $submit = new Element\Submit('submit');
        $submit->setValue('crear curso');
        $submit->setAttribute('class', 'btn btn-primary');

        $this->add($title);
        $this->add($goal);
        $this->add($description);
        $this->add($category);
        $this->add($submit);
    }
} 