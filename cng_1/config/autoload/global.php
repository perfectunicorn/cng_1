<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',

            'Zend\Authentication\AuthenticationService' => function(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
                /**
                 * @var \User\Service\UserService $userService
                 */
                $userService = $serviceLocator->get('User\Service\UserService');
                return $userService->getAuthenticationService();
            },
           // 'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
                    
        /*'aliases' => array(
            'translator' => 'MvcTranslator',
        ),  */         
    ),
                         
    'doctrine' => array(
        'migrations_configuration' => array(
            'orm_default' => array(
                'directory' => 'data/migrations',
            ),
        ),
    ),
);
