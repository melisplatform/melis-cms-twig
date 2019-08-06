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

use RuntimeException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EnvironmentFactory implements FactoryInterface
{

    /**
     * Create service
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Twig\Environment
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \MelisCmsTwig\ModuleOptions $options */
        $options = $serviceLocator->get('MelisCmsTwig\ModuleOptions');
        $envClass = $options->getEnvironmentClass();

        if (!$serviceLocator->has($options->getEnvironmentLoader())) {
            throw new RuntimeException(
                sprintf(
                    'Loader with alias "%s" could not be found!',
                    $options->getEnvironmentLoader()
                )
            );
        }

        /** @var \Twig\Environment $env */
        $env = new $envClass($serviceLocator->get($options->getEnvironmentLoader()), $options->getEnvironmentOptions());

        return $env;
    }
}