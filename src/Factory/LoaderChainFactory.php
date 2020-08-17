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
use InvalidArgumentException;
use Twig\Loader\ChainLoader as Twig_Loader_Chain;

class LoaderChainFactory
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return object|Twig_Loader_Chain
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \MelisCmsTwig\ModuleOptions $options */
        $options = $container->get('MelisCmsTwig\ModuleOptions');

        /** Setup Loader */
        $chain = new Twig_Loader_Chain();
        foreach ($options->getLoaderChain() as $loader) {
            if (!is_string($loader) || !$container->has($loader)) {
                throw new InvalidArgumentException('Loaders should be a service manager alias.');
            }
            $chain->addLoader($container->get($loader));
        }

        return $chain;
    }
}