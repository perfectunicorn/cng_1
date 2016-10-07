<?php
//
namespace Blog\Controller;

use Blog\Entity\Post;
use Blog\Entity\Comment;
use Blog\Form\Add;
use Blog\Form\Edit;
use Blog\Form\CommentsForm;
use Blog\InputFilter\AddPost;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel(array(
            'paginator' => $this->getBlogService()->fetch($this->params()->fromRoute('page')),
        ));
    }

    public function addAction()
    {
        if (!$user = $this->identity()) {
            $this->flashMessenger()->addErrorMessage('You must be logged in to add posts');
            return $this->redirect()->toRoute('blog');
        }

        $form = new Add();
        $variables = array('form' => $form);

        if ($this->request->isPost()) {
            $blogPost = new Post();
            $form->bind($blogPost);
            $form->setInputFilter(new AddPost());
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->getBlogService()->save($blogPost, $user->id);
                $this->flashMessenger()->addSuccessMessage('The post has been added!');
            }
        }

        return new ViewModel($variables);
    }

    public function viewPostAction()
    {
        
         if (!$user = $this->identity()) {
            $this->flashMessenger()->addErrorMessage('You must be logged in to view blog');
            return $this->redirect()->toRoute('blog');
        }
        
        $categorySlug = $this->params()->fromRoute('categorySlug');
        $postSlug = $this->params()->fromRoute('postSlug');
        $post = $this->getBlogService()->find($categorySlug, $postSlug);

        $form=new CommentsForm();
        

        if ($post == null) {
         
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
        }
     
        if ($this->request->isPost()) {
            $blogPost = new Comment();
            $form->bind($blogPost);

            $form->setData($this->request->getPost());

            if ($form->isValid()) {
 
                $this->getBlogService()->saveComment($blogPost, $user->id,$post->getId());
                $this->flashMessenger()->addSuccessMessage('The comment has been added!');
            }
        }

        $paginator=$this->getBlogService()->findCommentsByPost($post->getId(),$this->params()->fromRoute('page'));

        return new ViewModel(array(
            'post' => $post,
            'form' => $form,
            'paginator' => $paginator,
        ));
    }


    public function editAction()
    {
        $form = new Edit();

        if ($this->request->isPost()) {
            $post = new Post();
            $form->bind($post);
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->getBlogService()->update($post);
                $this->flashMessenger()->addSuccessMessage('The post has been updated!');
            }
        } else {
             $categorySlug = $this->params()->fromRoute('categorySlug');
             $postSlug = $this->params()->fromRoute('postSlug');
             $post = $this->getBlogService()->find($categorySlug, $postSlug);

            if ($post == null) {
                $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            } else {
                $form->bind($post);
                $form->get('category_id')->setValue($post->getCategory()->getId());
                $form->get('slug')->setValue($post->getSlug());
                $form->get('id')->setValue($post->getId());
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function deleteAction()
    {
        $this->getBlogService()->delete($this->params()->fromRoute('postId'));
        $this->flashMessenger()->addSuccessMessage('The post has been deleted!');
        return $this->redirect()->toRoute('blog');
    }

    
    protected function getBlogService()
    {
        return $this->getServiceLocator()->get('Blog\Service\BlogService');
    }
} 