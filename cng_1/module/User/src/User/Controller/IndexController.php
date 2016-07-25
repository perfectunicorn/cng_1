<?php

namespace User\Controller;

use User\Entity\User;
use User\Form\Add;
use User\Form\Login;
use User\Form\fileUpload;
use User\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Form\InputFilter\InputFilter;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/user');
        return new ViewModel();
       
    }

    public function addAction()
    {
        $this->layout('layout/user');
        $form = new Add();

        if ($this->request->isPost()) {
            $user = new User();
            $form->bind($user);
            $form->setInputFilter($this->getServiceLocator()->get('User\InputFilter\AddUser'));
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $user->setUserGroup(UserService::GROUP_REGULAR);
                $this->getUserService()->add($user);
                $this->flashMessenger()->addSuccessMessage('Cuenta creada');
                return $this->redirect()->toRoute('login');
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function loginAction()
    {
        $this->layout('layout/user');
        if ($this->identity() != null) {
            $this->flashMessenger()->addInfoMessage('Bienvenido');
            return $this->redirect()->toRoute('user');
        }

        $form = new Login();

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            $form->setInputFilter(new \User\InputFilter\Login());

            if ($form->isValid()) {
                $data = $form->getData();
                $loginResult = $this->getUserService()->login($data['email'], $data['password']);

                if ($loginResult) {
                    $this->flashMessenger()->addSuccessMessage('Bienvenido');
                    return $this->redirect()->toRoute('user');
                } else {
                    $this->flashMessenger()->addErrorMessage('Usuario o contraseña inválidos');
                    return $this->redirect()->toRoute('login');
                }
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function logoutAction()
    {
        $this->layout('layout/user');
        /**
         * @var \Zend\Authentication\AuthenticationService $authenticationService
         */
        $authenticationService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authenticationService->clearIdentity();
        $this->flashMessenger()->addSuccessMessage('Has cerrado sesión');

        return $this->redirect()->toRoute('login');
    }
    
    public function profileAction()
    {
        $this->layout('layout/user');
        if (!$user = $this->identity()) {
            $this->flashMessenger()->addErrorMessage('No estás autorizado para ver perfiles');
            return $this->redirect()->toRoute('user');
        }
        
        //cambiar por nickname
        $userId = $this->params()->fromRoute('userId');
        $member = $this->getUserService()->findById($userId);
       
        if ($member == null) {
            //$this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return $this->redirect()->toRoute('user');
        }
       
        return new ViewModel(array(
            'member' => $member,
        ));
    }
    
    
    public function uploadsAction()
    {
          $this->layout('layout/user');
        return new ViewModel(array(
            'paginator' => $this->getUploadsService()->fetchAll($this->params()->fromRoute('page')),
        ));
    }
    
    public function getFileUploadLocation()
    {
        // Fetch Configuration from Module Config
        $config  = $this->getServiceLocator()->get('config');
        return $config['module_config']['upload_location'];
    }
    
    public function uploadAction()
    {
        
        $this->layout('layout/user');
       if (!$user = $this->identity()) {
             $this->flashMessenger()->addErrorMessage('No estás autorizado para subir archivos');
            return $this->redirect()->toRoute('user');
        }
        
        $form     = new fileUpload('upload-form');
    $tempFile = null;

    $prg = $this->fileprg($form);
    if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
        return $prg; // Return PRG redirect response
    } elseif (is_array($prg)) {
        if ($form->isValid()) {
            $data = $form->getData();
            // Form is valid, save the form!
            return $this->redirect()->toRoute('profile',array('userId' => $user->id));
        } else {
            // Form not valid, but file uploads might be valid...
            // Get the temporary file information to show the user in the view
            $fileErrors = $form->get('image-file')->getMessages();
            if (empty($fileErrors)) {
                $tempFile = $form->get('image-file')->getValue();
            }
        }
    }

    return array(
        'form'     => $form,
        'tempFile' => $tempFile,
    );
    }

    /**
     * @return \User\Service\UserService
     */
    protected function getUserService()
    {
        return $this->getServiceLocator()->get('User\Service\UserService');
    }
    
     protected function getUploadsService()
    {
        return $this->getServiceLocator()->get('User\Service\UploadsService');
    }
} 