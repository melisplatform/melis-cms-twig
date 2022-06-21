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
                'environment_class' => 'Twig\Environment',

                /**
                 * Options that are passed directly to the Twig_Environment.
                 */
                'environment_options' => [
                    'debug' => true,
                    'cache' => __DIR__ . '/../cache/',
                    'auto_reload' => 'true',
                ],

                /**
                 * Service manager alias of any additional loaders to register with the chain. The default
                 * has the TemplateMap and TemplatePathStack registered. This setting only has an effect
                 * if the `environment_loader` key above is set to MelisCmsTwigLoaderChain.
                 */
                'loader_chain' => [
                    'MelisCmsTwigTemplateMap',
                    'MelisCmsTwigTemplatePathStack',
                ],

                /**
                 * Set to 'true' to use Twig's Template Inheritance
                 * instead of Laminas Framework's notion of parent/child layout
                 */
                'enable_twig_model' => true,

                /**
                 * Twig can load *any* type of file, but Laminas Framework's templates do not specify their suffix.
                 * Which is why we set the template's file extension / suffix that Twig will look for.
                 *
                 * - Used by MelisCmsTwigTemplatePathStack (or any future loaders), appended as an extension to a
                 * templateName when searching (resolving) templates inside the FileSystem
                 *
                 * - or Twig's "extends": Ex. {% extends my/module/template %} -> Twig will look for template.<suffix>
                 */
                'suffix' => 'twig',//'phtml',

                /**
                 * Register your extensions here.
                 * Service manager alias or fully qualified domain name of extensions.
                 */
                'extensions' => [
                    'MelisCmsTwigExtension',
                    'Twig\Extension\DebugExtension',
                ],

                /**
                 * Set to true, make ZF2 view helpers available inside Twig templates
                 * This will slightly degrade performance but must be used if you plan using any of ZF2's view helpers.
                 */
                'enable_fallback_functions' => true,
            ],
        ],
    ],
];
