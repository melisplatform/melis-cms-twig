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
use MelisCmsTwig\MapLoader;

class MapLoaderFactory
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return MapLoader|object
     * @throws \Twig\Error\LoaderError
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /**
         * @var \MelisCmsTwig\MapLoader $templateMap
         * @var \Laminas\View\Resolver\TemplateMapResolver $zfTemplateMap
         */
        $zfTemplateMap = $container->get('ViewTemplateMapResolver');
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