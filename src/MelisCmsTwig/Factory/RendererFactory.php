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


use MelisCmsTwig\Renderer;
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
        /** @var \MelisCmsTwig\ModuleOptions $options */
        $options = $serviceLocator->get('MelisCmsTwig\ModuleOptions');

        $renderer = new Renderer(
            $serviceLocator->get('Zend\View\View'),
            $serviceLocator->get('Twig_Loader_Chain'),
            $serviceLocator->get('Twig_Environment'),
            $serviceLocator->get('MelisCmsTwig\Resolver')
        );

        $renderer->canRenderTrees($options->getDisableZfmodel());

        return $renderer;
    }
}