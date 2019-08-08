<?php

return [
    'plugins' => [
        'MelisCmsTwig' => [
            'conf' => [
                /**
                 * Service manager alias of the loader to use with MelisCmsTwig. By default, it uses
                 * the included MelisCmsTwigLoaderChain which includes a copy of ZF2's TemplateMap and
                 * TemplatePathStack.
                 */
                'environment_loader' => 'MelisCmsTwigLoaderChain',

                /**
                 * Optional class name override for instantiating the Twig Environment in the factory.
                 */
                'environment_class' => 'Twig_Environment',

                /**
                 * Options that are passed directly to the Twig_Environment.
                 */
                'environment_options' => array(),

                /**
                 * Service manager alias of any additional loaders to register with the chain. The default
                 * has the TemplateMap and TemplatePathStack registered. This setting only has an effect
                 * if the `environment_loader` key above is set to MelisCmsTwigLoaderChain.
                 */
                'loader_chain' => array(
                    'MelisCmsTwigTemplateMap',
                    'MelisCmsTwigTemplatePathStack',
                ),
            ],
        ],
    ],
];
