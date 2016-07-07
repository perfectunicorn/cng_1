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
            $this->flashMessenger()->addErrorMessage('You must be logged in to add posts');
            return $this->redirect()->toRoute('courses');
        }

        $form = new Add();
        $variables = array('form' => $form);

        if ($this->request->isPost()) {
            $course = new Course();
            $form->bind($course);
            $form->setInputFilter(new AddCourse());
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->getCoursesService()->save($course, $user->id);
                $this->flashMessenger()->addSuccessMessage('The post has been added!');
            }
        }

        return new ViewModel($variables);
    }

    
    /**
     * @return \Courses\Service\CoursesService $blogService
     */
    protected function getCoursesService()
    {
        return $this->getServiceLocator()->get('Courses\Service\CoursesService');
    }
} 