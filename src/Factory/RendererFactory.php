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


use Psr\Container\ContainerInterface;
use InvalidArgumentException;
use MelisCmsTwig\Renderer;
use MelisCmsTwig\Resolver;
use Twig\Environment as Twig_Environment;
use Twig\Extension\AbstractExtension as Twig_Extension;
use Twig\Loader\ChainLoader as Twig_Loader_Chain;

class RendererFactory
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return Renderer
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /**
         * Register extensions
         *
         * @var \MelisCmsTwig\ModuleOptions $options
         * @var Twig_Environment $env
         * @var Twig_Extension $extension
         */
        $options = $container->get('MelisCmsTwig\ModuleOptions');
        $env = $container->get('Twig_Environment');

        foreach ($options->getExtensions() as $extension) {
            // Allows modules to override/remove extensions.
            if (empty($extension)) {
                continue;
            } else if (is_string($extension)) {
                if ($container->has($extension)) {
                    $extension = $container->get($extension);
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
         * @var \Laminas\View\View $view
         * @var Resolver $resolver
         */
        $view = $container->get('Laminas\View\View');
        $loaderChain = $container->get('MelisCmsTwigLoaderChain');
//        $resolver = $container->get('MelisCmsTwig\Resolver');
        $resolver = new Resolver($container->get('Twig_Environment'));
        $renderer = new Renderer($view, $loaderChain, $env, $resolver);

        $renderer->setCanRenderTrees($options->getEnableTwigModel());

        return $renderer;
    }
}