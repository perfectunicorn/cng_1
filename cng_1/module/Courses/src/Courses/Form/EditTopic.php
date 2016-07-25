<?php

namespace Courses\Form;

use Courses\Entity\Hydrator\CategoryHydrator;
use Courses\Entity\Hydrator\CourseHydrator;
use Courses\Entity\Hydrator\TopicHydrator;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class EditTopic extends Form
{
    public function __construct()
    {
        parent::__construct('edit');

        $hydrator = new AggregateHydrator();
        $hydrator->add(new TopicHydrator());
        $hydrator->add(new CourseHydrator());
        $hydrator->add(new CategoryHydrator());
        $this->setHydrator($hydrator);

        $id = new Element\Hidden('id');
        $courseId = new Element\Hidden('courseId');

        $title = new Element\Text('topic_title');
        $title->setLabel('Título del tema');
        $title->setAttribute('class', 'form-control');

        $slug = new Element\Text('topic_slug');
        $slug->setLabel('Slug');
        $slug->setAttribute('class', 'form-control');

        $content = new Element\Textarea('topic_content');
        $content->setLabel('Contenido');
        $content->setAttribute('class', 'form-control');


        $submit = new Element\Submit('submit');
        $submit->setValue('Crear tema');
        $submit->setAttribute('class', 'btn btn-primary');

        $this->add($id);
        $this->add($courseId);
        $this->add($title);
        $this->add($slug);
        $this->add($content);
        $this->add($submit);
    }
}