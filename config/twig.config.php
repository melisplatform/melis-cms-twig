<?php

return [
    'plugins' => [
        'MelisCmsTwig' => [
            'conf' => [
                /**
                 * Service manager alias of the loader to use with MelisCmsTwig. By default, it uses
                 * the included MelisCmsTwig\LoaderChain which includes a copy of ZF2's TemplateMap and
                 * TemplatePathStack.
                 */
                'environment_loader' => 'MelisCmsTwig\LoaderChain',

                /**
                 * Optional class name override for instantiating the Twig Environment in the factory.
                 */
                'environment_class' => 'MelisTwigEnvironment',

                /**
                 * Options that are passed directly to the Twig_Environment.
                 */
                'environment_options' => array(),

                /**
                 * Service manager alias of any additional loaders to register with the chain. The default
                 * has the TemplateMap and TemplatePathStack registered. This setting only has an effect
                 * if the `environment_loader` key above is set to ZfcTwigLoaderChain.
                 */
                'loader_chain' => array(
                    'MelisCmsTwig\TemplateMap',
//                    'MelisCmsTwig\TemplatePathStack'
                ),

            ],
//            'ressources' => [
//                'js' => [],
//                'css' => [],
//                'build' => [
//                    'disable_bundle' => false,
//                    // lists of assets that will be loaded in the layout
//                    'css' => [
//                        //'/MelisCmsTwig/build/css/bundle.css',
//                    ],
//                    'js' => [
//                        //'/MelisCmsTwig/build/js/bundle.js',
//                    ]
//                ]
//            ],
//            'datas' => [],
//            'interface' => [],
        ],
    ],
];
