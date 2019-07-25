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
                'child_routes' => [
//                    'application-MelisCmsTwig' => [
//                        'type' => 'Literal',
//                        'options' => [
//                            'route' => 'MelisCmsTwig',
//                            'defaults' => [
//                                '__NAMESPACE__' => 'MelisCmsTwig\Controller',
//                                'controller' => 'MelisCmsTwigTab',
//                                'action' => 'test',
//                            ],
//                        ],
//                        // this route will be accessible in the browser by browsing
//                        // www.domain.com/melis/MelisCmsComments/controller/action
//                        'may_terminate' => true,
//                        'child_routes' => [
//                            'default' => [
//                                'type' => 'Segment',
//                                'options' => [
//                                    'route' => '/[:controller[/:action]]',
//                                    'constraints' => [
//                                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                                    ],
//                                    'defaults' => [
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
                ],
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
        ],
        'factories' => [
            'MelisCmsTwig\ModuleOptions' => 'MelisCmsTwig\Factory\ModuleOptionsFactory',
            
            //service
//            'MelisCmsCommentsService' => 'MelisCmsComments\Service\Factory\MelisCmsCommentsServiceFactory',
//            'MelisCmsCommentsTable' => 'MelisCmsComments\Model\Tables\Factory\MelisCmsCommentsTableFactory',
        ],
    ],

    'controllers' => [
        'invokables' => [
//            'MelisCmsComments\Controller\MelisCmsCommentsTab' => 'MelisCmsComments\Controller\MelisCmsCommentsTabController',
//            'MelisCmsComments\Controller\Dashboard' => 'MelisCmsComments\Controller\DashboardController',
//            'MelisCmsComments\Controller\MelisCmsCommentsViewHelper' => 'MelisCmsComments\Controller\MelisCmsCommentsViewHelperController',
        ],
    ],
    'controller_plugins' => [
        'invokables' => [
//            'MelisCmsCommentsPlugin' => 'MelisCmsComments\Controller\Plugin\MelisCmsCommentsPlugin',

            // Dashboard plugins
//            'MelisCmsCommentsLatestCommentsPlugin' => 'MelisCmsComments\Controller\DashboardPlugins\MelisCmsCommentsLatestCommentsPlugin',
        ]
    ],

    'form_elements' => [
        'factories' => [

        ],
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