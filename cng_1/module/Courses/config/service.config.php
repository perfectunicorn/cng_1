<?php

namespace Courses;

return array(
    'invokables' => array(
        'Courses\Repository\CourseRepository' => 'Courses\Repository\CourseRepositoryImpl',
    ),

    'factories' => array(
        'Courses\Service\CoursesService' => function(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
            $blogService = new \Courses\Service\CoursesServiceImpl();
            $blogService->setCoursesRepository($serviceLocator->get('Courses\Repository\CourseRepository'));

            return $blogService;
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