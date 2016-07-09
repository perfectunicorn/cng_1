<?php

namespace Courses;

return array(
    'invokables' => array(
        'Courses\Repository\CourseRepository' => 'Courses\Repository\CourseRepositoryImpl',
    ),

    'factories' => array(
        'Courses\Service\CoursesService' => function(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
            $coursesService = new \Courses\Service\CoursesServiceImpl();
            $coursesService->setCoursesRepository($serviceLocator->get('Courses\Repository\CourseRepository'));

            return $coursesService;
        },
    ),

    'initializers' => array(
        function($instance, \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
            if ($instance instanceof \Zend\Db\Adapter\AdapterAwareInterface) {
                $instance->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'));
            }
        },
    ),
);