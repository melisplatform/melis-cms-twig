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


use MelisCmsTwig\StackLoader;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Resolver\TemplatePathStack;

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
        /** @var TemplatePathStack $zfTemplateStack */
        $zfTemplateStack = $serviceLocator->get('ViewTemplatePathStack');
        $templateStack = new StackLoader($zfTemplateStack->getPaths()->toArray());

        /** @var \MelisCmsTwig\ModuleOptions $options */
        $options = $serviceLocator->get('MelisCmsTwig\ModuleOptions');
        $templateStack->setDefaultSuffix($options->getSuffix());

        return $templateStack;
    }
}