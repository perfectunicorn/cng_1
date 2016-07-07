<?php

namespace Blog;

return array(
    'invokables' => array(
        'Blog\Repository\PostRepository' => 'Blog\Repository\PostRepositoryImpl',
    ),

    'factories' => array(
        'Blog\Service\BlogService' => function(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
            $blogService = new \Blog\Service\BlogServiceImpl();
            $blogService->setBlogRepository($serviceLocator->get('Blog\Repository\PostRepository'));

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