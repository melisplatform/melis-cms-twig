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
        'invokables' => [

        ],
        'aliases' => [
            'translator' => 'MvcTranslator',
            'MelisTwigEnvironment' => 'MelisCmsTwig\Environment',
        ],
        'factories' => [
            'MelisCmsTwig\LoaderChain' => 'MelisCmsTwig\Factory\LoaderChainFactory',
            'MelisCmsTwig\TemplateMap' => 'MelisCmsTwig\Factory\MapLoaderFactory',
            'MelisCmsTwig\TemplatePathStack' => 'MelisCmsTwig\Factory\StackLoaderFactory',

            'MelisCmsTwig\Environment' => 'MelisCmsTwig\Factory\EnvironmentFactory',
            'MelisCmsTwig\ModuleOptions' => 'MelisCmsTwig\Factory\ModuleOptionsFactory',
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
        'template_map' => [

        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];