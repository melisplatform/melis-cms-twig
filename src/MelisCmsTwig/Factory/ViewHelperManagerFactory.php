<?php
/**
 * Created by PhpStorm.
 * User: ksuso
 * Date: 8/29/2019
 * Time: 7:05 PM
 */

namespace MelisCmsTwig\Factory;


use Zend\ServiceManager\Config;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Exception;
use Zend\View\HelperPluginManager;

class ViewHelperManagerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return HelperPluginManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \MelisCmsTwig\ModuleOptions $options */
        $options = $serviceLocator->get('MelisCmsTwig\ModuleOptions');
        $managerOptions = $options->getHelperManager();
        $managerConfigs = empty($managerOptions['configs']) ? [] : $managerOptions['configs'];

        $baseManager = $serviceLocator->get('ViewHelperManager');
        $helperManager = new HelperPluginManager(new Config($managerOptions));
        $helperManager->setServiceLocator($serviceLocator);
        $helperManager->addPeeringServiceManager($baseManager);

        foreach ($managerConfigs as $configClass) {
            if (is_string($configClass) && class_exists($configClass)) {
                $config = new $configClass;

                if (!$config instanceof ConfigInterface) {
                    throw new Exception\RuntimeException(
                        sprintf(
                            'Invalid service manager configuration class provided. Received "%s", 
                            expected class implementing %s',
                            $configClass,
                            'Zend\ServiceManager\ConfigInterface'
                        )
                    );
                }

                $config->configureServiceManager($helperManager);
            }
        }

        return $helperManager;
    }
}