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


use MelisCmsTwig\Renderer;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\View\ViewEvent;

class MelisCmsTwigStrategyListener implements ListenerAggregateInterface
{
    /** @var \Zend\Stdlib\CallbackHandler[] */
    protected $listeners = [];

    /** @var  Renderer */
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

    }

    /**
     * Determines if the renderer can load the requested template
     *
     * @param ViewEvent $e
     * @return bool|Renderer
     */
    public function selectRenderer(ViewEvent $e)
    {
        $template = $e->getModel()->getTemplate();
        if ($this->renderer->canRender($e->getModel()->getTemplate())) {
            /**
             *
             * ADDITIONAL CHECKING GOES HERE:
             *  CHECK IF TEMPLATE TYPE IS 'TWG'
             *
             */
            return $this->renderer;
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
        $result = $e->getResult();
        $response = $e->getResponse();

        $response->setContent($result);
    }
}
