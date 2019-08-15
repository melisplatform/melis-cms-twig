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
                'environment_options' => [],

                /**
                 * Service manager alias of any additional loaders to register with the chain. The default
                 * has the TemplateMap and TemplatePathStack registered. This setting only has an effect
                 * if the `environment_loader` key above is set to MelisCmsTwigLoaderChain.
                 */
                'loader_chain' => array(
                    'MelisCmsTwigTemplateMap',
                    'MelisCmsTwigTemplatePathStack',
                ),

                /**
                 * Set to 'true' to use 'Twig's Inheritance Model',
                 * instead of Zend Framework's notion of parent/child layout
                 */
                'enable_twig_model' => true,

                /**
                 * When enabled, the ZF2 view helpers will get pulled using a fallback renderer. This will
                 * slightly degrade performance but must be used if you plan on using any of ZF2's view helpers.
                 */
//                'enable_fallback_functions' => false,

                /**
                 * Setting the template's file extension / suffix Twig will look for.
                 *
                 * - Used by MelisCmsTwigTemplatePathStack (or any future loaders), appended as an extension to a
                 * templateName when searching (resolving) templates inside the FileSystem
                 *
                 * - or Twig's "extends": Ex. {% extends my/module/template %} -> Twig will look for template.<suffix>
                 */
                'suffix' => 'phtml',
            ],
        ],
    ],
];
