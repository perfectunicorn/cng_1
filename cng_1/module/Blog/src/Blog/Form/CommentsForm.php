<?php

namespace Blog\Form;

use Blog\Entity\Hydrator\CommentHydrator;
use Blog\Entity\Hydrator\ReplyHydrator;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class CommentsForm extends Form
{
    public function __construct()
    {
        parent::__construct('add');

        $hydrator = new AggregateHydrator();
        $hydrator->add(new CommentHydrator());
        //$hydrator->add(new ReplyHydrator());
        $this->setHydrator($hydrator);
        
        $id = new Element\Hidden('id');
        $post_id = new Element\Hidden('post_id');
        
        $comment = new Element\Text('comment');
        $comment->setLabel('Reply');
        $comment->setAttribute('class', 'form-control');

        $submit = new Element\Submit('submit');
        $submit->setValue('post');
        $submit->setAttribute('class', 'btn btn-primary');

        $this->add($id);
        $this->add($comment);
        $this->add($submit);
    }
} 