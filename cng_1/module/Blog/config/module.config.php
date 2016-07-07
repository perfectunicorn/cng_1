<?php

namespace Blog;

return array(
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /blog/:controller/:action
            'blog' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/blog',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Blog\Controller',
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
                                'controller' => 'Blog\Controller\Index',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),

            'display-post' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/blog/posts/:categorySlug/:postSlug',
                    'constraints' => array(
                        'categorySlug' => '[a-zA-Z0-9-]+',
                        'postSlug' => '[a-zA-Z0-9-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Index',
                        'action' => 'viewPost',
                    ),
                ),
            ),

            'edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/blog/edit/:postId',
                    'constraints' => array(
                        'postId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Index',
                        'action' => 'edit',
                    ),
                ),
            ),

            'delete' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/blog/delete/:postId',
                    'constraints' => array(
                        'postId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Index',
                        'action' => 'delete',
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'Blog\Controller\Index' => Controller\IndexController::class
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);