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
use MelisCmsTwig\Listener\MelisCmsTwigStrategyListener;

class StrategyFactory
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return MelisCmsTwigStrategyListener
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MelisCmsTwigStrategyListener($container->get('MelisCmsTwigRenderer'));
    }
}