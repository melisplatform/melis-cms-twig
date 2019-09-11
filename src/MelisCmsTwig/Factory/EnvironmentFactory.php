<?php
/**
 * Melis Technology (http://www.melistechnology.com)
 *
 * @copyright Copyright (c) 2019 Melis Technology (http://www.melistechnology.com)
 *
 * Patterned using ZendFramework-Commons ZfcTwig @link https://github.com/ZF-Commons/ZfcTwig
 *
 */

namespace MelisCmsTwig\Factory;

use RuntimeException;
use Twig\Environment;
use Twig_Function;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Renderer\PhpRenderer;

class EnvironmentFactory implements FactoryInterface
{
    /**
     * Create service
     * @param ServiceLocatorInterface $serviceLocator
     * @return Environment
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \MelisCmsTwig\ModuleOptions $options */
        $options = $serviceLocator->get('MelisCmsTwig\ModuleOptions');
        $envClass = $options->getEnvironmentClass();

        if (!$serviceLocator->has($options->getEnvironmentLoader())) {
            throw new RuntimeException(
                sprintf(
                    'Loader with alias "%s" could not be found!',
                    $options->getEnvironmentLoader()
                )
            );
        }

        /** @var Environment $env - class name is retrieved from 'environment_class' key in "twig.config.php" */
        $env = new $envClass($serviceLocator->get($options->getEnvironmentLoader()), $options->getEnvironmentOptions());

        /**
         * To use Zend Framework's View Helpers (ex. Layout, Doctype, FlashMessenger, Url, etc.)
         *
         * - In "config/twig.config.php", set 'enable_fallback_functions' to true
         * - To use the helpers without rewriting them all as Twig Extensions, MelisCmsTwig is using Twig Environment's
         *  "registerUndefinedFunctionCallback" method to register a function that will use ZF2's PhpRenderer to render
         *  the ViewHelper.
         *
         * Source: https://akrabat.com/using-zf2-forms-with-twig/
         */
        if ($options->getEnableFallbackFunctions()) {
            $renderer = $serviceLocator->get('ViewRenderer');
            $viewHelperManager = $serviceLocator->get('ViewHelperManager');
            $renderer->setHelperPluginManager($viewHelperManager);

            $env->registerUndefinedFunctionCallback(
                function ($name) use ($viewHelperManager, $renderer) {
                    // check the ViewHelperManager to see if we have a view helper that we can call
                    if (!$viewHelperManager->has($name)) {
                        return false;
                    }

                    /**
                     * - Instantiate the ViewHelper using a Twig_Function that will call the helper's invoke method
                     * - Tell Twig that the ViewHelper is_safe to use HTML so Twig does not escape the helper's tags
                     */
                    $callable = [$renderer->plugin($name), '__invoke'];
                    $options = ['is_safe' => ['html']];

                    return new Twig_Function($name, $callable, $options);
                }
            );
        }

        /**
         * Extensions are loaded later to avoid circular dependencies (for example, if an extension needs Renderer).
         * Source: https://twig.symfony.com/doc/2.x/api.html#using-extensions
         */
        return $env;
    }
}