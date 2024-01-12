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
use MelisCmsTwig\Extension;

class ExtensionFactory
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return Extension|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Extension();
    }
}