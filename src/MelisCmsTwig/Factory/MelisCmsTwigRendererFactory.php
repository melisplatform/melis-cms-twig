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


use MelisCmsTwig\MelisCmsTwigRenderer;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MelisCmsTwigRendererFactory implements FactoryInterface
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
         * @var $options
         * @var
         * @var \MelisCmsTwig\MelisCmsTwigRenderer $renderer
         */
        $options = $serviceLocator->get('MelisCmsTwig\ModuleOptions');
        $view = $serviceLocator->get('Zend\View\View');
        $chain = $serviceLocator->get('MelisCmsTwig\LoaderChain');
        $env = $serviceLocator->get('MelisCmsTwig\Environment');
        $resolver = $serviceLocator->get('MelisCmsTwig\Resolver');
        $renderer = new MelisCmsTwigRenderer($view, $chain, $env, $resolver);

        $renderer->canRenderTrees($options->getDisableZfmodel());

        return $renderer;
    }
}