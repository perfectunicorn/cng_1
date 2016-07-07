<?php

namespace Courses;

return array(
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /blog/:controller/:action
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
                    'route' => '/courses/posts/:categorySlug/:postSlug',
                    'constraints' => array(
                        'categorySlug' => '[a-zA-Z0-9-]+',
                        'postSlug' => '[a-zA-Z0-9-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Courses\Controller\Index',
                        'action' => 'viewPost',
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
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/courses'=>__DIR__.'/../view/layout/courses.phtml',
            'courses/index/index' => __DIR__ . '/../view/courses/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);