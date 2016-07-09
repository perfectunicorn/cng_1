<?php

namespace Courses;

return array(
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /courses/:controller/:action
            'courses' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/courses',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Courses\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                        'page'          => 1,
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),

                    'paged' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/page/:page',
                            'constraints' => array(
                                'page' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Courses\Controller\Index',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),

            'display-course' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/courses/courses/:categorySlug/:courseSlug',
                    'constraints' => array(
                        'categorySlug' => '[a-zA-Z0-9-]+',
                        'courseSlug' => '[a-zA-Z0-9-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Courses\Controller\Index',
                        'action' => 'viewCourse',
                    ),
                ),
            ),

            'edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/courses/edit/:courseId',
                    'constraints' => array(
                        'courseId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Courses\Controller\Index',
                        'action' => 'edit',
                    ),
                ),
            ),

            'delete' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/courses/delete/:courseId',
                    'constraints' => array(
                        'courseId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Courses\Controller\Index',
                        'action' => 'delete',
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'Courses\Controller\Index' => Controller\IndexController::class
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);