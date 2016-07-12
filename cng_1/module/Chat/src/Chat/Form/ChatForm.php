<?php

namespace Chat\Form;

use Zend\Form\Form;
use Zend\Form\Element;


class ChatForm extends Form
{
    public function __construct()
    {
        parent::__construct('chat');
        
        $message = new Element\Text('message');
        $message->setLabel('mensaje');
        $message->setAttributes(array(
            'id'=>'messageText',
            'required'=>'required'
        ));

        $submit = new Element\Submit('submit');
        $submit->setValue('Enviar');
        $submit->setAttribute('class', 'btn btn-primary');
        
        $refresh = new Element\Submit('submit');
        $refresh->setValue('Refresh');
        $refresh->setAttributes(array(
            'id'=>'btnRefresh',
            'class'=>'btn btn-primary'
        ));
        $this->add($message);
        $this->add($submit);
        $this->add($refresh);
    }
} 