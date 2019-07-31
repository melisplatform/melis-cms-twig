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


use MelisCmsTwig\MapLoader;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MapLoaderFactory implements FactoryInterface
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
         * @var \MelisCmsTwig\ModuleOptions $options
         * @var \MelisCmsTwig\MapLoader $templateMap
         * @var \Zend\View\Resolver\TemplateMapResolver $zfTemplateMap
         */
        $options = $serviceLocator->get('MelisCmsTwig\ModuleOptions');
        $zfTemplateMap = $serviceLocator->get('ViewTemplateMapResolver');
        $templateMap = new MapLoader();

        /** Mapping files loaded by ZendFramework's Template Resolver */
        foreach ($zfTemplateMap as $name => $path) {
//            if ($options->getSuffix() == pathinfo($path, PATHINFO_EXTENSION)) {
            $templateMap->add($name, $path);
//            }
        }

        return $templateMap;
    }
}