<?php

namespace User;

return array(
    'router' => array(
        'routes' => array(      
                'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /user/:controller/:action
            'user' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
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
                ),
            ),

            'login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action' => 'login',
                    ),
                ),
            ),

            'logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action' => 'logout',
                    ),
                ),
            ),
            
            'sign-up' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user/index/add',
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action' => 'add',
                    ),
                ),
            ),
            
             'courses' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/courses',
                    'defaults' => array(
                        'controller' => 'Courses\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            
             'welcome' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/welcome',
                    'defaults' => array(
                        'controller' => 'Welcome\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            
             'blog' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/blog',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'User\Controller\Index' => Controller\IndexController::class
        ),
    ),

      'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            //'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/user'=>__DIR__.'/../view/layout/user.phtml',
            'welcome/index/index' => __DIR__ . '/../view/welcome/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);