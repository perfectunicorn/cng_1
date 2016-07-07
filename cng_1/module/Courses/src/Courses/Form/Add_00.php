<?php

/* 
 * Here comes the text of your license
 * Each line should be prefixed with  * 
 */

namespace Courses\Form;

use Courses\Entity\Hydrator\CategoryHydrator;
use Courses\Entity\Hydrator\PostHydrator;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class Add extends Form
{
    public function __construct()
    {
        parent::__construct('add');

        /*$hydrator = new AggregateHydrator();
        $hydrator->add(new PostHydrator());
        $hydrator->add(new CategoryHydrator());
        $this->setHydrator($hydrator);*/

        $title = new Element\Text('title');
        $title->setLabel('Nombre del curso');
        $title->setAttribute('class', 'input-field col s12');

        $goal = new Element\Text('goal');
        $goal->setLabel('Objetivo');
        $goal->setAttribute('class', 'input-field col s12');

        $description = new Element\Textarea('description');
        $description->setLabel('Descripción');
        $description->setAttribute('class', 'input-field col s12');

        $category = new Element\Select('category_id');
        $category->setLabel('Categoría');
        $category->setAttribute('class','input-field col s12');
        $category->setValueOptions(array(
            1 => 'Zend Framework',
            2 => 'PHP',
            3 => 'MySQL',
        ));

        $submit = new Element\Submit('submit');
        $submit->setValue('Crear curso');
        $submit->setAttribute('class', 'waves-effect waves-light btn');

        $this->add($title);
        $this->add($goal);
        $this->add($description);
        $this->add($category);
        $this->add($submit);
    }
}