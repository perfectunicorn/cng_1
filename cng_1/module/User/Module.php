<?php

namespace User;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Validator\AbstractValidator;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface, ServiceProviderInterface, AutoloaderProviderInterface
{
    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return include __DIR__ . '/config/service.config.php';
    }
    
    public function onBootstrap(MvcEvent $e)
    {
        date_default_timezone_set('America/Mexico_City');

        $serviceManager = $e->getApplication()->getServiceManager();
        $translator = $serviceManager->get('translator');

        //$locale = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $locale = 'es_ES';
        //$locale = 'en_US';

        $translator->setLocale(\Locale::acceptFromHttp($locale));
        $translator->addTranslationFile(
            'phpArray',
            'vendor/zendframework/zend-i18n-resources/languages/es/Zend_Validate.php',
            'default',
            'es_ES'
        );
        AbstractValidator::setDefaultTranslator($translator);
    }
    
}