<?php

/* 
 * Here comes the text of your license
 * Each line should be prefixed with  * 
 */
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Form\AvatarForm;
use User\Entity\Avatar;
use Zend\Validator\File\Size;
 
class AvatarController extends AbstractActionController
{
    public function indexAction()
    {
        $form = new AvatarForm();
        $request = $this->getRequest();  
        $user=$this->identity();
        
        if ($request->isPost()) {
             
            $profile = new Avatar();
            $form->setInputFilter($profile->getInputFilter());
             
            $nonFile = $request->getPost()->toArray();
            $File    = $this->params()->fromFiles('fileupload');
            $data = array_merge(
                 $nonFile,
                 array('fileupload'=> $File['name'])
             );
            //set data post and file ...    
            $form->setData($data);
              
            if ($form->isValid()) {
                 
                $size = new Size(array('max'=>2000000)); //max bytes filesize
                 
                $adapter = new \Zend\File\Transfer\Adapter\Http(); 
                $adapter->setValidators(array($size), $File['name']);
             
                if (!$adapter->isValid()){
           
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach($dataError as $key=>$row)
                    {
                        $error[] = $row;
                    }
                    $form->setMessages(array('fileupload'=>$error ));
                      
                } else {
                    $adapter->setDestination(getcwd().'/public/img/profile');
                   
                    foreach ($adapter->getFileInfo() as $info) {
                      
                        $adapter->addFilter('File\Rename',
                            array('target' => $adapter->getDestination().'/'.$user->nickname.'.png',
                            'overwrite' => true));

                        if ($adapter->receive($info['name'])) {
                            $file = $adapter->getFilter('File\Rename')->getFile();
                            print_r($file[0]['target']);
                        }
                    }
                   
                   if ($adapter->receive($File['name'])) {
                        $profile->exchangeArray($form->getData());
                        echo 'Profile Name '.$user->nickname.' upload '.$profile->fileupload;
                        
                    }
                }  
            } 
            return $this->redirect()->toRoute('profile',array('nickname'=>$user->nickname));
        }
          
        return array('form' => $form);
    }
}