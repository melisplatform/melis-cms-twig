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

use Interop\Container\ContainerInterface;
use RuntimeException;
use Twig\Environment;
use Twig\TwigFunction;
use Laminas\View\Renderer\PhpRenderer;

/**
 * Class EnvironmentFactory
 * @package MelisCmsTwig\Factory
 */
class EnvironmentFactory
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return Environment
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \MelisCmsTwig\ModuleOptions $options */
        $options = $container->get('MelisCmsTwig\ModuleOptions');
        $envClass = $options->getEnvironmentClass();

        if (!$container->has($options->getEnvironmentLoader())) {
            throw new RuntimeException(
                sprintf(
                    'Loader with alias "%s" could not be found!',
                    $options->getEnvironmentLoader()
                )
            );
        }

        /** @var Environment $env - class name is retrieved from 'environment_class' key in "twig.config.php" */
        $env = new $envClass($container->get($options->getEnvironmentLoader()), $options->getEnvironmentOptions());

        /**
         * To use Laminas Framework's View Helpers (ex. Layout, Doctype, FlashMessenger, Url, etc.)
         *
         * - In "config/twig.config.php", set 'enable_fallback_functions' to true
         * - To use the helpers without rewriting them all as Twig Extensions, MelisCmsTwig is using Twig Environment's
         *  "registerUndefinedFunctionCallback" method to register a function that will use ZF2's PhpRenderer to render
         *  the ViewHelper.
         *
         * Source: https://akrabat.com/using-zf2-forms-with-twig/
         */
        if ($options->getEnableFallbackFunctions()) {
            $renderer = $container->get('ViewRenderer');
            $viewHelperManager = $container->get('ViewHelperManager');
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

                    return new TwigFunction($name, $callable, $options);
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