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
use MelisCmsTwig\StackLoader;
use Laminas\ServiceManager\FactoryInterface;

class StackLoaderFactory
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return StackLoader
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var TemplatePathStack $zfTemplateStack */
        $zfTemplateStack = $container->get('ViewTemplatePathStack');
        $templateStack = new StackLoader($zfTemplateStack->getPaths()->toArray());

        /** @var \MelisCmsTwig\ModuleOptions $options */
        $options = $container->get('MelisCmsTwig\ModuleOptions');
        $templateStack->setDefaultSuffix($options->getSuffix());

        return $templateStack;
    }
}