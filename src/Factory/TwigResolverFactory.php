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
use MelisCmsTwig\Resolver;

class TwigResolverFactory
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return Resolver|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Resolver($container->get('Twig_Environment'));
    }
}