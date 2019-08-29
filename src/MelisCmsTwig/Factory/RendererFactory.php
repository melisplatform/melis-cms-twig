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


use InvalidArgumentException;
use MelisCmsTwig\Renderer;
use MelisCmsTwig\Resolver;
use Twig\Environment as Twig_Environment;
use Twig\Extension\AbstractExtension as Twig_Extension;
use Twig\Loader\ChainLoader as Twig_Loader_Chain;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RendererFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * Register extensions
         *
         * @var \MelisCmsTwig\ModuleOptions $options
         * @var Twig_Environment $env
         * @var Twig_Extension $extension
         */
        $options = $serviceLocator->get('MelisCmsTwig\ModuleOptions');
        $env = $serviceLocator->get('Twig_Environment');

        foreach ($options->getExtensions() as $extension) {
            // Allows modules to override/remove extensions.
            if (empty($extension)) {
                continue;
            } else if (is_string($extension)) {
                if ($serviceLocator->has($extension)) {
                    $extension = $serviceLocator->get($extension);
                } else {
                    $extension = new $extension();
                }
            } elseif (!is_object($extension)) {
                throw new InvalidArgumentException('Extensions should be a string or object.');
            }

            $env->addExtension($extension);
        }

        /**
         * @var Twig_Loader_Chain $loaderChain
         * @var \Zend\View\View $view
         * @var Resolver $resolver
         */
        $view = $serviceLocator->get('Zend\View\View');
        $loaderChain = $serviceLocator->get('MelisCmsTwigLoaderChain');
        $resolver = $serviceLocator->get('MelisCmsTwig\Resolver');
        $renderer = new Renderer($view, $loaderChain, $env, $resolver);

        $renderer->setCanRenderTrees($options->getEnableTwigModel());
        $renderer->setHelperPluginManager($serviceLocator->get('MelisCmsTwigViewHelperManager'));

        return $renderer;
    }
}