<?php

/**
 * Melis Technology (http://www.melistechnology.com)
 *
 * @copyright Copyright (c) 2019 Melis Technology (http://www.melistechnology.com)
 *
 */

namespace MelisCmsTwig;

use MelisCmsTwig\Listener\MelisTwigRenderingStrategy;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\Stdlib\ArrayUtils;

/**
 * Class Module
 * @package MelisCmsTwig
 */
class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        /** @var \Zend\Mvc\MvcEvent $e */
        $application = $e->getApplication();
        $eventManager = $application->getEventManager();
        $serviceManager = $application->getServiceManager();
        $environment = $serviceManager->get('MelisTwigEnvironment');

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $routeMatch = $serviceManager->get('router')->match($serviceManager->get('request'));
        $this->createTranslations($e, $routeMatch);

        /**
         * Set-up extension(s), if there exists any.
         * @var  $options
         */
//        $options = $sm->get('');
//        $environment = $sm->get('Twig_Environment');
//        foreach ($options->getExtensions() as $extension) {
//            $environment->addExtension($extension);
//        }

        /** attach Listener(s) */
        $eventManager->attach(new MelisTwigRenderingStrategy());
    }

    public function createTranslations($e, $routeMatch)
    {
        $sm = $e->getApplication()->getServiceManager();
        $translator = $sm->get('translator');
        $param = $routeMatch->getParams();
        // Checking if the Request is from Melis-BackOffice or Front
        $renderMode = (isset($param['renderMode'])) ? $param['renderMode'] : 'melis';
        if ($renderMode == 'melis') {
            $container = new Container('meliscore');
            $locale = $container['melis-lang-locale'];
        } else {
            $container = new Container('melisplugins');
            $locale = $container['melis-plugins-lang-locale'];
        }
        if (!empty($locale)) {

            $translationType = [
                'interface',
            ];

            $translationList = [];
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/../module/MelisModuleConfig/config/translation.list.php')) {
                $translationList = include 'module/MelisModuleConfig/config/translation.list.php';
            }

            foreach ($translationType as $type) {
                $transPath = '';
                $moduleTrans = __NAMESPACE__ . "/$locale.$type.php";

                if (in_array($moduleTrans, $translationList)) {
                    $transPath = "module/MelisModuleConfig/languages/" . $moduleTrans;
                }

                if (empty($transPath)) {
                    // if translation is not found, use melis default translations
                    $defaultLocale = (file_exists(__DIR__ . "/../language/$locale.$type.php")) ? $locale : "en_EN";
                    $transPath = __DIR__ . "/../language/$defaultLocale.$type.php";
                }

                $translator->addTranslationFile('phparray', $transPath);
            }
        }
    }

    public function getConfig()
    {
        $config = [];
        $configFiles = [
            include __DIR__ . '/../config/module.config.php',
            include __DIR__ . '/../config/twig.config.php',
        ];

        foreach ($configFiles as $file) {
            $config = ArrayUtils::merge($config, $file);
        }

        return $config;
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
}