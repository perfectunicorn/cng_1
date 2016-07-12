<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Chat\Controller;

use Chat\Form\ChatForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $user=$this->identity();
        $request=$this->getRequest();
        if($request->isPost()){
            $messageTest=$request->getPost()->get('message');
            $fromUserId=$user->id;
            $this->sendMessage($messageTest, $fromUserId);
            return $this->redirect()->toRoute('chat/index/');
        }
        
        $form=new ChatForm();
        return new ViewModel(array(
            'form' => $form,'userName'=>$user->first_name
        ));
   
    }
    
     public function messageListAction()
    {
        if (!$user = $this->identity()) {
            $this->flashMessenger()->addErrorMessage('You must be logged in chat');
            return $this->redirect()->toRoute('chat');
        }
        
        $userTable=$this->getServiceLocator()->get('User');
        $chatMessagesTG=$this->getServiceLocator()->get('ChatMessagesTableGateway');
        $chatMessages=$chatMessagesTG->select();
        
        $messageList=array();
        foreach ($chatMessages as $chatMessage) {
            $fromUser=$userTable->getUser($chatMessage->user_id);
            $messageData=array();
            $messageData['user']=$fromUser->first_name;
            $messageData['time']=$chatMessage->stamp;
            $messageData['data']=$chatMessage->message;
            $messageList[]=$messageData;
            
        }
        
        $viewModel=new ViewModel(array(
            'messageList'=>$messageList));
        $viewModel->setTemplate('chat/index/message-list');
        $viewModel->setTerminal(true);
     
        return $viewModel;
    }
    
    
    public function sendMessage($messageTest,$fromUserId)
    {
        if (!$user = $this->identity()) {
            $this->flashMessenger()->addErrorMessage('You must be logged in chat');
            return $this->redirect()->toRoute('chat');
        }
        
        //$userTable=$this->getServiceLocator()->get('User');
        $chatMessagesTG=$this->getServiceLocator()->get('ChatMessagesTableGateway');
        $data=array(
            'user_id'=>$fromUserId,
            'message'=>$messageTest,
            'stamp'=>null
            
        );
        $chatMessages=$chatMessagesTG->insert($data);
        return true;
    }
}
