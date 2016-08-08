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
                        'controller' => 'User\Controller\Index',
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
                'type' => 'Literal',
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
            
               'profile' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user/:nickname',
                    'constraints' => array(
                        'nickname' => '[a-zA-Z0-9-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action' => 'profile',
                    ),
                ),
            ),
            
              'upload' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user/upload/:userId',
                    'constraints' => array(
                        'userId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action' => 'upload',
                    ),
                ),
            ),
            
             'avatar' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user/avatar',
                    'defaults' => array(
                        'controller' => 'User\Controller\Avatar',
                        'action' => 'index',
                    ),
                ),
            ),
            
            'edit-info' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user/about/:nickname',
                    'constraints' => array(
                        'nickname' => '[a-zA-Z0-9-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action' => 'edit',
                    ),
                ),
            ),
            
            'add-job' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user/add-job',
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action' => 'addJob',
                    ),
                ),
            ),
            
             'add-education' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user/add-education',
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action' => 'addEducation',
                    ),
                ),
            ),
            
            'add-project' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user/add-project',
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action' => 'addProject',
                    ),
                ),
            ),
            
             'edit-job' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user/edit-job/:jobId',
                    'constraints' => array(
                        'jobId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action' => 'editJob',
                    ),
                ),
            ),
            
             'edit-education' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user/edit-education/:educationId',
                    'constraints' => array(
                        'educationId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action' => 'editEducation',
                    ),
                ),
            ),
            
            'edit-course' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/edit-course/:courseId',
                    'constraints' => array(
                        'courseId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Courses\Controller\Index',
                        'action' => 'edit',
                    ),
                ),
            ),
            
            'edit-project' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user/edit-project/:projectId',
                    'constraints' => array(
                        'projectId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action' => 'editProject',
                    ),
                ),
            ),
            
             'add-course' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/add-course',
                    'defaults' => array(
                        'controller' => 'Courses\Controller\Index',
                        'action' => 'add',
                    ),
                ),
            ),
            
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'User\Controller\Index' => Controller\IndexController::class,
            'User\Controller\Avatar' => Controller\AvatarController::class,
            'Courses\Controller\Index' => 'Courses\Controller\IndexController',
        ),
    ),

      'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => false,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            //'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/user'=>__DIR__.'/../view/layout/user.phtml',
            'user/index/index' => __DIR__ . '/../view/user/index/index.phtml',
            'user/profile' => __DIR__ . '/../view/user/index/profile.phtml',
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
    
    'module_config' => array(
        'upload_location' => __DIR__ . '/data/uploads',
  ),
);