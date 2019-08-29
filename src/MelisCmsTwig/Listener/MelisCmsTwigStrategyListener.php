<?php
/**
 * Melis Technology (http://www.melistechnology.com)
 *
 * @copyright Copyright (c) 2019 Melis Technology (http://www.melistechnology.com)
 *
 * Patterned using ZendFramework-Commons ZfcTwig @link https://github.com/ZF-Commons/ZfcTwig
 *
 */

namespace MelisCmsTwig\Listener;

use InvalidArgumentException;
use MelisCmsTwig\Renderer;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\View\Model\ViewModel;
use Zend\View\ViewEvent;

class MelisCmsTwigStrategyListener implements ListenerAggregateInterface
{
    private const TWIG_TEMPLATE = 'TWG';
    private const UPPERCASE = '/(?=[A-Z])/';
    private const HYPHEN = '-';

    /**
     * Used inside a view file/script to refer to the page's default layout name
     *  Ex. {% extends baseTemplate %}
     */
    private const DEFAULT_LAYOUT_VAR_NAME = 'baseTemplate';

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     * @var  Renderer
     */
    protected $listeners = [];
    protected $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Attach one or more listeners
     * - Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     * @param int $priority
     */
    public function attach(EventManagerInterface $events, $priority = 100)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, [$this, 'selectRenderer'], $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, [$this, 'injectResponse'], $priority);
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

    /**
     * Determines if the renderer can load the requested template
     *
     * @param ViewEvent $e
     * @return bool|Renderer
     */
    public function selectRenderer(ViewEvent $e)
    {
        $view = $e->getModel();
        $viewVars = $view->getVariables();

        if (empty($viewVars) || !method_exists($viewVars, 'offsetGet')) {
            return false;
        } else {
            $pageTemplate = $viewVars->offsetGet("pageTemplate");
            /**
             * Check for Twig Template ("TWG" template type)
             */
            if (!empty($pageTemplate->tpl_type) && $pageTemplate->tpl_type === self::TWIG_TEMPLATE) {
                if ($this->renderer->canRender($view->getTemplate())) {
                    /**
                     * Get the "Requested View" (i.e. module/controller/action)
                     * using the PageTemplate's site module (hyphen-separated-format, ex. melis-demo-cms)
                     */
                    $pageSite = preg_split(self::UPPERCASE, $pageTemplate->tpl_zf2_website_folder, -1, PREG_SPLIT_NO_EMPTY);
                    $pageSite = strtolower(implode(self::HYPHEN, $pageSite));

                    $requestedView = null;
                    foreach ($view->getChildren() as $child) {
                        if (is_int(strpos($child->getTemplate(), $pageSite))) {
                            $requestedView = $child; // Renamed "Child View" to "Requested View" for readability
                            break;
                        }
                        //else detach listeners for this child
                    }

                    if (!empty($requestedView) && $this->renderer->canRender($requestedView->getTemplate())) {
                        /**
                         * Do "The Swap"
                         *
                         * - Set the Page Template's layout as a ViewModel variable self::DEFAULT_LAYOUT_VAR_NAME,
                         * this template will be extended using Twig's {% extends %}.
                         *
                         * - Set the "Requested View" (i.e. module/controller/action) as the model's template
                         */
                        $newView = new ViewModel();
                        $newView->setVariable(self::DEFAULT_LAYOUT_VAR_NAME, $view->getTemplate());
                        $newView->setVariables($requestedView->getVariables());
                        $newView->setTemplate($requestedView->getTemplate());

                        $e->setModel($newView);
                    }

                    return $this->renderer;
                }
            }
        }

        return false;
    }


    /**
     * Inject the response from the renderer.
     *
     * @param \Zend\View\ViewEvent $e
     */
    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->renderer) {
            return;
        }

        $e->getResponse()->setContent($e->getResult());
    }
}
