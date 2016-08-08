<?php

/* 
 * Here comes the text of your license
 * Each line should be prefixed with  * 
 */
namespace User\Form;

use Zend\Form\Form;
 
class AvatarForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Profile');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');
         
        $this->add(array(
            'name' => 'profilename',
            'attributes' => array(
                'type'  => 'hidden',
            ),
            'options' => array(
                'label' => 'Nombre de usuario',
                
            ),
        ));
 
         
        $this->add(array(
            'name' => 'fileupload',
            'attributes' => array(
                'type'  => 'file',
            ),
            'options' => array(
                'label' => 'File Upload',
            ),
        )); 
         
         
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Upload Now'
            ),
        )); 
    }
}

