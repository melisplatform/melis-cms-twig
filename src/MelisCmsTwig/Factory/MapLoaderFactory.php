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
         * @var \MelisCmsTwig\MapLoader $templateMap
         * @var \Zend\View\Resolver\TemplateMapResolver $zfTemplateMap
         */
        $zfTemplateMap = $serviceLocator->get('ViewTemplateMapResolver');
        $templateMap = new MapLoader();

        /** Mapping files loaded by ZendFramework's Template Resolver */
        foreach ($zfTemplateMap as $name => $path) {
            $templateMap->add($name, $path);
        }

        return $templateMap;
    }
}