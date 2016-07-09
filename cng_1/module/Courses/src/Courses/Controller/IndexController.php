<?php

namespace Courses\Controller;

use Courses\Entity\Hydrator\CategoryHydrator;
use Courses\Entity\Hydrator\CourseHydrator;
use Courses\Entity\Course;
use Courses\Form\Add;
use Courses\Form\Edit;
use Courses\InputFilter\AddCourse;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel(array(
            'paginator' => $this->getCoursesService()->fetch($this->params()->fromRoute('page')),
        ));
    }

    public function addAction()
    {
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
                var_dump($blogPost);
                $this->getCoursesService()->save($blogPost, $user->id);
                
                $this->flashMessenger()->addSuccessMessage('The course has been added!');
            }
        }
        
        return new ViewModel($variables);
    }

    public function viewCourseAction()
    {
        $categorySlug = $this->params()->fromRoute('categorySlug');
        $courseSlug = $this->params()->fromRoute('courseSlug');
        $course = $this->getCoursesService()->find($categorySlug, $courseSlug);

        if ($course == null) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
        }

        return new ViewModel(array(
            'course' => $course,
        ));
    }

    public function editAction()
    {
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
        $this->getCoursesService()->delete($this->params()->fromRoute('courseId'));
        $this->flashMessenger()->addSuccessMessage('The course has been deleted!');
        return $this->redirect()->toRoute('courses');
    }

    /**
     * @return \Courses\Service\CoursesService $coursesService
     */
    protected function getCoursesService()
    {
        return $this->getServiceLocator()->get('Courses\Service\CoursesService');
    }
} 