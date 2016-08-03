<?php

namespace User\Controller;

use User\Entity\User;
use User\Entity\Career;
use User\Form\Add;
use User\Form\AddJob;
use User\Form\Edit;
use User\Form\Login;
use User\Form\fileUpload;
use User\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use User\Form\InputFilter\InputFilter;

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
    
    /*
     * Edit basic info: first name, last name, age, gender & bio
     */
    public function editAction()
    {
       $this->layout('layout/user');
        $form = new Edit();

        if ($this->request->isPost()) {
            $user = new User();
            $form->bind($user);
            $form->setData($this->request->getPost());
            

            if ($form->isValid()) {
                $this->getUserService()->update($user);
                $nickname=$this->getUserService()->findByNickname($this->params()->fromRoute('nickname'));
                $this->flashMessenger()->addSuccessMessage('Información de usuario actualizada');
                return $this->redirect()->toRoute('profile',array('nickname'=>$nickname->getNickname()));
            }
        } else {
            $user = $this->getUserService()->findByNickname($this->params()->fromRoute('nickname'));

            if ($user == null) {
                $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            } else {
                $form->bind($user);
                $form->get('firstName')->setValue($user->getFirstName());
                $form->get('lastName')->setValue($user->getLastName());
                $form->get('gender')->setValue($user->getGender());
                $form->get('age')->setValue($user->getAge());
                $form->get('bio')->setValue($user->getBio());
                $form->get('id')->setValue($user->getId());
            }
        }

        return new ViewModel(array(
            'form' => $form,
        )); 
    }
    
    /*
     * Edit user role
     */
    public function editRoleAction()
    {
        
    }
     
    /*
     *  Delete user account
     *  Only Admin's role, for now
     */
    public function deleteAction()
    {
        
    }
    
    /*
     * Education options
     */
    public function addEducationAction()
    {
        
    }
    
    public function editEducationAction()
    {
        
    }
    
    public function deleteEducationAction()
    {
        
    }
    
    /*
     * Career options
     */
    public function addJobAction()
    {
        $this->layout('layout/user');
        if (!$user = $this->identity()) {
            $this->flashMessenger()->addErrorMessage('You must be logged in to add any data on profile');
            return $this->redirect()->toRoute('profile');
        }

        $form = new AddJob();
        $variables = array('form' => $form);

        if ($this->request->isPost()) {
            $blogPost = new Career();
            $form->bind($blogPost);
            //$form->setInputFilter(new AddJob());
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                
                var_dump($blogPost);
                $this->getUserService()->addCareer($blogPost, $user->id);
                
                $this->flashMessenger()->addSuccessMessage('The job has been added!');
            }
        }
        
        return new ViewModel($variables);
    }
    
    public function editJobAction()
    {
            $this->layout('layout/user');
        $form = new AddJob();

        if ($this->request->isPost()) {
            $career = new Career();
            $form->bind($career);
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->getUserService()->update($career);
                $this->flashMessenger()->addSuccessMessage('The course has been updated!');
            }
        } else {
            $career = $this->getUserService()->findCareerById($this->params()->fromRoute('jobId'));

            if ($career == null) {
               // $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            } else {
                $form->bind($career);
                $form->get('organization')->setValue($career->getOrganization);
                $form->get('position')->setValue($career->getPosition());
                $form->get('id')->setValue($career->getId());
            }
        }

        return new ViewModel(array(
            'form' => $form,
        )); 
    }
    
    public function deleteJobAction()
    {
        
    }
    
     /*
     * Projects options
     */
    public function addProjectAction()
    {
        
    }
    
    public function editProjectAction()
    {
        
    }
    
    public function deleteProjectAction()
    {
        
    }

    /*
     * Authentication actions
     */
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
    
    /*public function profileAction()
    {
        $this->layout('layout/user');
        if (!$user = $this->identity()) {
            $this->flashMessenger()->addErrorMessage('No estás autorizado para ver perfiles');
            return $this->redirect()->toRoute('user');
        }
        
        //cambiar por nickname
        $userId = $this->params()->fromRoute('nickname');
        $member = $this->getUserService()->findById($userId);
       
        if ($member == null) {
            //$this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return $this->redirect()->toRoute('user');
        }
       
        return new ViewModel(array(
            'member' => $member,
        ));
    }*/
    
    public function profileAction()
    {
        $this->layout('layout/user');
        if (!$user = $this->identity()) {
            $this->flashMessenger()->addErrorMessage('No estás autorizado para ver perfiles');
            return $this->redirect()->toRoute('user');
        }
        
        //cambiar por nickname
        $userId = $this->params()->fromRoute('nickname');
        $member = $this->getUserService()->findByNickname($userId);
        $career=$this->getUserService()->findCareerByUser($member->getId());

        if ($member == null) {
            //$this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            return $this->redirect()->toRoute('user');
        }
       
        return new ViewModel(array(
            'member' => $member,'career'=>$career,
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