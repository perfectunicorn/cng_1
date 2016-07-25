<?php

namespace Courses\Controller;

use Courses\Entity\Hydrator\CategoryHydrator;
use Courses\Entity\Hydrator\CourseHydrator;
use Courses\Entity\Hydrator\TopicHydrator;
use Courses\Entity\Course;
use Courses\Entity\Topic;
use Courses\Form\Add;
use Courses\Form\Edit;
use Courses\Form\AddTopic;
use Courses\Form\EditTopic;
use Courses\InputFilter\AddCourse;
use Courses\InputFilter\TopicFilter;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
          $this->layout('layout/courses');
        return new ViewModel(array(
            'paginator' => $this->getCoursesService()->fetch($this->params()->fromRoute('page')),
        ));
    }

    public function addAction()
    {
        $this->layout('layout/courses');
        if (!$user = $this->identity()) {
            $this->flashMessenger()->addErrorMessage('You must be logged in to add courses');
            return $this->redirect()->toRoute('courses');
        }

        $form = new Add();
        $variables = array('form' => $form);

        if ($this->request->isPost()) {
            $blogPost = new Course();
            $form->bind($blogPost);
            $form->setInputFilter(new AddCourse());
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                
                $this->getCoursesService()->save($blogPost, $user->id);
                
                $this->flashMessenger()->addSuccessMessage('The course has been added!');
            }
        }
        
        return new ViewModel($variables);
    }

    public function viewCourseAction()
    {
        $this->layout('layout/courses');
        $categorySlug = $this->params()->fromRoute('categorySlug');
        $courseSlug = $this->params()->fromRoute('courseSlug');
        $course = $this->getCoursesService()->find($categorySlug, $courseSlug);
        //var_dump($course->getId());
        $paginator=$this->getCoursesService()->fetchTopicsByCourse($course->getId(),$this->params()->fromRoute('page'));

        if ($course == null) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
        }
        return new ViewModel(array(
            'course' => $course,'paginator'=>$paginator
        ));
    }

    public function editAction()
    {
        $this->layout('layout/courses');
        $form = new Edit();

        if ($this->request->isPost()) {
            $course = new Course();
            $form->bind($course);
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->getCoursesService()->update($course);
                $this->flashMessenger()->addSuccessMessage('The course has been updated!');
            }
        } else {
            $course = $this->getCoursesService()->findById($this->params()->fromRoute('courseId'));

            if ($course == null) {
                $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            } else {
                $form->bind($course);
                $form->get('category_id')->setValue($course->getCategory()->getId());
                $form->get('slug')->setValue($course->getSlug());
                $form->get('id')->setValue($course->getId());
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function deleteAction()
    {
        $this->layout('layout/courses');
        $this->getCoursesService()->delete($this->params()->fromRoute('courseId'));
        $this->flashMessenger()->addSuccessMessage('The course has been deleted!');
        return $this->redirect()->toRoute('courses');
    }

    /*
     * Topics actions
     * 
     * 
     */
    public function addTopicAction()
    {
        $this->layout('layout/courses');
        if (!$user = $this->identity()) {
            $this->flashMessenger()->addErrorMessage('You must be logged in to add courses');
            return $this->redirect()->toRoute('courses');
        }
        
        $course = $this->getCoursesService()->findById($this->params()->fromRoute('courseId'));
        
        $form = new AddTopic();
        $variables = array('form' => $form);
       

        if ($this->request->isPost()) {
            $blogPost = new Topic(); 
            $form->bind($blogPost);
             
            $form->setInputFilter(new TopicFilter());
            $form->setData($this->request->getPost());
            
            if ($form->isValid()) {
                //var_dump($blogPost);
                $course = $this->getCoursesService()->findById($this->params()->fromRoute('courseId'));
                $this->getCoursesService()->saveTopic($blogPost, $user->id,$course->id);
                $this->flashMessenger()->addSuccessMessage('The topic has been added!');
            }
        }else {
            $course = $this->getCoursesService()->findById($this->params()->fromRoute('courseId'));
            if ($course == null) {
                $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            } else {
                $form->bind($course);
                $form->get('courseId')->setValue($course->id);
            }
        }
        
        return new ViewModel($variables);
    }

    public function editTopicAction()
    {
        $this->layout('layout/courses');
        $form = new EditTopic();

        if ($this->request->isPost()) {
            $topic = new Topic();
            $form->bind($topic);
            $form->setData($this->request->getPost());
                        
            if ($form->isValid()) {
                $this->getCoursesService()->updateTopic($topic);
                $this->flashMessenger()->addSuccessMessage('The topic has been updated!');
            }
        } else {
            
            $topic = $this->getCoursesService()->findTopicById($this->params()->fromRoute('topicId'));
             var_dump($topic);
            if ($topic == null) {
                $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            } else {
                $form->bind($topic);
                $form->get('id')->setValue($topic->getId());
                $form->get('topic_title')->setValue($topic->getTitle());
                $form->get('topic_slug')->setValue($topic->getSlug());
                $form->get('topic_content')->setValue($topic->getContent());
                //$form->get('course_id')->setValue($topic->getCourse()->getId());

            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function deleteTopicAction()
    {
        $this->layout('layout/courses');
        $this->getCoursesService()->deleteTopic($this->params()->fromRoute('topicId'));
        $this->flashMessenger()->addSuccessMessage('The topic has been deleted!');
        return $this->redirect()->toRoute('courses');
    }
    

    public function viewTopicAction()
    {
        $this->layout('layout/courses');
        $topicSlug = $this->params()->fromRoute('topicSlug');
        $topic = $this->getCoursesService()->findTopic($topicSlug);
        if ($topic == null) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
        }

        return new ViewModel(array(
            'topic' => $topic,
        ));
    }
    
    /**
     * @return \Courses\Service\CoursesService $coursesService
     */
    protected function getCoursesService()
    {
        return $this->getServiceLocator()->get('Courses\Service\CoursesService');
    }
} 