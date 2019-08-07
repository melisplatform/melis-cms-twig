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


use Twig\Environment as Twig_Environment;
use Twig\Error\LoaderError as Twig_Error_Loader;
use Twig\Loader\FilesystemLoader;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;

class MelisTwigRenderingStrategy implements ListenerAggregateInterface
{
    private const VIEW_MODEL = 'Zend\View\Model\ViewModel';
    private const TWIG_TEMPLATE = 'TWG';

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * @var Twig_Environment
     */
    protected $environment;

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, [$this, 'render'], -999);
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
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * Renders the "twigged" view of a page
     * whose template type is Twig - "TWG"
     *
     * @param MvcEvent $e
     * @return null|\Zend\Stdlib\ResponseInterface
     */
    public function render(MvcEvent $e)
    {
        $result = $e->getResult();
        if ($result instanceof Response) {
            return $result;
        }

        $viewModel = $e->getViewModel();
        if (!empty($viewModel) && get_class($viewModel) === self::VIEW_MODEL && $viewModel->getVariables()) {
            /** Get Page's type of template */
            $template = $viewModel->getVariables()->offsetGet("pageTemplate") ?? null;

            if (!empty($template) && $template->tpl_type === self::TWIG_TEMPLATE) {
                $ds = DIRECTORY_SEPARATOR;

                /** Convert CamelCase -> dash-separated-string (i.e. MelisDemoCms -> melis-demo-cms) */
                $folder = lcfirst($template->tpl_zf2_website_folder);
                $pieces = preg_split('/(?=[A-Z])/', $folder);
                $folder = strtolower(implode("-", $pieces));

                $path = getcwd() . $ds . "vendor$ds" . "melisplatform$ds" . "$folder$ds" . "view$ds" . "$folder$ds" . strtolower($template->tpl_zf2_controller);

                /** @var Twig_Environment $env */
                $loader = new FilesystemLoader($path);
                $env = new Twig_Environment($loader);

                try {
                    /** render using Twig */
                    $result = $env->render(
                        $template->tpl_zf2_action,
                        (array)$viewModel->getVariables()
                    );
                } catch (Twig_Error_Loader $e) {
                    return null;
                }
                $e->getResponse()->setContent($result);

                return $e->getResponse()->getContent();
            }
        }

        return null;
    }
}
