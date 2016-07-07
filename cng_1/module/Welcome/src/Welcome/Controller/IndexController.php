<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Welcome\Controller;

use User\Entity\User;
use User\Form\Add;
use User\Form\Login;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/welcome');
        if ($this->identity() != null) {
            $this->flashMessenger()->addErrorMessage('You are already logged in!');
            return $this->redirect()->toRoute('user');
        }
     
        return new ViewModel();
    }
    
    public function welcomeAction()
    {
        return newModel();
    }
}
