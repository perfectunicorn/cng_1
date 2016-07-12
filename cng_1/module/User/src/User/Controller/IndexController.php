<?php

namespace User\Controller;

use User\Entity\User;
use User\Form\Add;
use User\Form\Login;
use User\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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

    /**
     * @return \User\Service\UserService
     */
    protected function getUserService()
    {
        return $this->getServiceLocator()->get('User\Service\UserService');
    }
} 