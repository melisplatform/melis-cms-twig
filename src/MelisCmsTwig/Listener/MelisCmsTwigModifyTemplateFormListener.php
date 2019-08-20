<?php

/**
 * Melis Technology (http://www.melistechnology.com)
 *
 * @copyright Copyright (c) 2019 Melis Technology (http://www.melistechnology.com)
 *
 */

namespace MelisCmsTwig\Listener;


use MelisCore\Listener\MelisCoreGeneralListener;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

/**
 * Modifies the Template Form inside the Template Manager (Melis CMS Site Tools)
 *  - Unhides & Converts the Template Type form element into a "Select"
 *  - Adds the additional Twig Template type under the allowable options (haystack)
 */
class MelisCmsTwigModifyTemplateFormListener extends MelisCoreGeneralListener implements ListenerAggregateInterface
{
    public function attach(EventManagerInterface $events)
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
                            $haystack = $formConfig['input_filter']['tpl_type']['validators'][0]['options']['haystack'];
                            if (empty($haystack)) {
                                break;
                            }

                            /** @var \Zend\ServiceManager\ServiceLocatorInterface $sm */
                            $sm = $e->getTarget()->getServiceLocator();
                            $translator = $sm->get('translator');

                            $valueOptions = [];
                            foreach ($haystack as $index => $tpl_type) {
                                $valueOptions[$tpl_type] = $translator->translate('tr_meliscmstwig_label_' . $tpl_type);
                            }

                            /**
                             * Converts the Template Type form element into a "Select"
                             * Adds the additional Twig Template type under the allowable options (haystack)
                             */
                            $formConfig['elements'][$idx]['spec'] = [
                                'name' => 'tpl_type',
                                'type' => 'select',
                                'options' => [
                                    'label' => $translator->translate('tr_meliscmstwig_label'),
                                    'value_options' => $valueOptions,
                                ],
                            ];

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