<?php

namespace Courses\Form;

use Courses\Entity\Hydrator\CategoryHydrator;
use Courses\Entity\Hydrator\CourseHydrator;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class Edit extends Form
{
    public function __construct()
    {
        parent::__construct('edit');

        $hydrator = new AggregateHydrator();
        $hydrator->add(new CourseHydrator());
        $hydrator->add(new CategoryHydrator());
        $this->setHydrator($hydrator);

        $id = new Element\Hidden('id');

        $title = new Element\Text('title');
        $title->setLabel('Nombre del curso');
        $title->setAttribute('class', 'form-control');

        $slug = new Element\Text('slug');
        $slug->setLabel('Slug');
        $slug->setAttribute('class', 'form-control');

        $content = new Element\Textarea('content');
        $content->setLabel('Descripción');
        $content->setAttribute('class', 'form-control');

        $category = new Element\Select('category_id');
        $category->setLabel('Categoría');
        $category->setAttribute('class', 'form-control');
        $category->setValueOptions(array(
            1 => 'Zend Framework',
            2 => 'PHP',
            3 => 'MySQL',
        ));

        $submit = new Element\Submit('submit');
        $submit->setValue('Crear curso');
        $submit->setAttribute('class', 'btn btn-primary');

        $this->add($id);
        $this->add($title);
        $this->add($slug);
        $this->add($content);
        $this->add($category);
        $this->add($submit);
    }
}