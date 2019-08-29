<?php
/**
 * Melis Technology (http://www.melistechnology.com)
 *
 * @copyright Copyright (c) 2019 Melis Technology (http://www.melistechnology.com)
 *
 */

return [
    'router' => [
        'routes' => [
            'melis-backoffice' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/melis[/]',
                ],
                'child_routes' => [],
            ],
        ],
    ],

    'translator' => [
        'locale' => 'en_EN',
    ],

    'service_manager' => [
        'invokables' => [],
        'aliases' => [
            'translator' => 'MvcTranslator',

            'MelisCmsTwigStrategy' => 'MelisCmsTwig\Listener\MelisCmsTwigStrategyListener',
            'MelisCmsTwigRenderer' => 'MelisCmsTwigRendererFactory',
            'MelisCmsTwigLoaderChain' => 'Twig_Loader_Chain',
            'MelisCmsTwigTemplateMap' => 'MelisCmsTwig\MapLoader',
            'MelisCmsTwigTemplatePathStack' => 'MelisCmsTwig\StackLoader',
            'MelisCmsTwigResolver' => 'MelisCmsTwigResolverFactory',
        ],
        'factories' => [
            'MelisCmsTwig\Listener\MelisCmsTwigStrategyListener' => 'MelisCmsTwig\Factory\StrategyFactory',
            'Twig_Environment' => 'MelisCmsTwig\Factory\EnvironmentFactory',
            'MelisCmsTwig\ModuleOptions' => 'MelisCmsTwig\Factory\ModuleOptionsFactory',
            'MelisCmsTwigExtension' => 'MelisCmsTwig\Factory\ExtensionFactory',
            'Twig_Loader_Chain' => 'MelisCmsTwig\Factory\LoaderChainFactory',
            'MelisCmsTwig\MapLoader' => 'MelisCmsTwig\Factory\MapLoaderFactory',
            'MelisCmsTwig\StackLoader' => 'MelisCmsTwig\Factory\StackLoaderFactory',
            'MelisCmsTwigRendererFactory' => 'MelisCmsTwig\Factory\RendererFactory',
            'MelisCmsTwigResolverFactory' => 'MelisCmsTwig\Factory\TwigResolverFactory',
            'MelisCmsTwigViewHelperManager' => 'MelisCmsTwig\Factory\ViewHelperManagerFactory',
        ],
    ],

    'controllers' => [
        'invokables' => [],
    ],
    'controller_plugins' => [
        'invokables' => [],
    ],

    'form_elements' => [
        'factories' => [],
    ],
    'asset_manager' => [
        'resolver_configs' => [
            'aliases' => [
                'MelisCmsTwig/' => __DIR__ . '/../public/',
            ],
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'template_map' => [],
        'template_path_stack' => [],
        'strategies' => [
            /**
             * Placing the value: "MelisCmsTwigStrategy" under "strategies" array key
             * will enable Melis CMS Twig Rendering for Twig Templates (i.e. Template Type = "TWG")
             */
            'MelisCmsTwigStrategy'
        ],
    ],
];
