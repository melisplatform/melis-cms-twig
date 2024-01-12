<?php

/**
 * Melis Technology (http://www.melistechnology.com)
 *
 * @copyright Copyright (c) 2019 Melis Technology (http://www.melistechnology.com)
 *
 */

namespace MelisCmsTwig\Listener;


use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use MelisCore\Listener\MelisGeneralListener;

/**
 * Modifies the Template Form inside the Template Manager (Melis CMS Site Tools)
 *  - Adds the additional Twig Template type under the allowable options (haystack)
 */
class MelisCmsTwigModifyTemplateFormListener extends MelisGeneralListener implements ListenerAggregateInterface
{
    public $listeners = [];
    
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $sharedEvents = $events->getSharedManager();

        $callBackHandler = $sharedEvents->attach(
            '*',
            'meliscms_template_form_config',
            function ($e) {
                $formConfig = $e->getParam('formConfig');

                if (is_array($formConfig) && !empty($formConfig)) {
                    foreach ($formConfig['elements'] as $idx => $element) {
                        if ($element['spec']['name'] === 'tpl_type') {
                            $sm = $e->getTarget()->getServiceManager();
                            $translator = $sm->get('translator');

                            /** Adds the additional Twig Template type (value option & input filter haystack) */
                            $formConfig['elements'][$idx]['spec']['options']['value_options']['TWG'] = $translator->translate('tr_meliscmstemplate_typ_TWG');
                            $formConfig['input_filter']['tpl_type']['validators'][0]['options']['haystack'][] = 'TWG';

                            $e->setParam('formConfig', $formConfig);

                            break;
                        }
                    }
                }

                return $e->getParam('formConfig');
            },
            100
        );

        $this->listeners[] = $callBackHandler;
    }
}