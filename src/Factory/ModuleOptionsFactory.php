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
use MelisCmsTwig\ModuleOptions;

class ModuleOptionsFactory
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return ModuleOptions
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Configuration');
        $options = empty($config['plugins']['MelisCmsTwig']['conf']) ? [] : $config['plugins']['MelisCmsTwig']['conf'];

        return new ModuleOptions($options);
    }
}
