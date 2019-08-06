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


use Twig_Loader_Filesystem;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class StackLoaderFactory implements FactoryInterface
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
         * @var \Zend\View\Resolver\TemplatePathStack $zfTemplateStack
         * @var Twig_Loader_Filesystem $templateStack
         */
        $zfTemplateStack = $serviceLocator->get('ViewTemplatePathStack');
        $templateStack = new Twig_Loader_Filesystem($zfTemplateStack->getPaths()->toArray());

        return $templateStack;
    }
}