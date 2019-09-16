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
     * @return MapLoader
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
            /**
             * OPTIONAL: Add a condition whether or not to add a template
             *  ex. Only templates whose file extension is ".twig"
             *      if ($Suffix == pathinfo($path, PATHINFO_EXTENSION))
             */
            $templateMap->add($name, $path);
        }

        return $templateMap;
    }
}