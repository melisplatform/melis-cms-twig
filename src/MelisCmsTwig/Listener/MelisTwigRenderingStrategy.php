<?php
///**
// * Melis Technology (http://www.melistechnology.com)
// *
// * @copyright Copyright (c) 2019 Melis Technology (http://www.melistechnology.com)
// *
// * Patterned using ZendFramework-Commons ZfcTwig @link https://github.com/ZF-Commons/ZfcTwig
// *
// */
//
//namespace MelisCmsTwig\Listener;
//
//
//use Exception;
//use Twig\Environment as Twig_Environment;
//use Twig\Loader\FilesystemLoader;
//use Zend\EventManager\EventManagerInterface;
//use Zend\EventManager\ListenerAggregateInterface;
//use Zend\Http\Response;
//use Zend\Mvc\MvcEvent;
//
//class MelisTwigRenderingStrategy implements ListenerAggregateInterface
//{
//    private const VIEW_MODEL = 'Zend\View\Model\ViewModel';
//    private const TWIG_TEMPLATE = 'ZF2';
//    private const TWG = 'twig';
//    private const TWG_EXT = '.twig';
//    private const ZF2_EXT = '.phtml';
//
//    /**
//     * @var \Zend\Stdlib\CallbackHandler[]
//     */
//    protected $listeners = array();
//
//    /**
//     * @var Twig_Environment
//     */
//    protected $environment;
//
//    /**
//     * Attach one or more listeners
//     *
//     * Implementors may add an optional $priority argument; the EventManager
//     * implementation will pass this to the aggregate.
//     *
//     * @param EventManagerInterface $events
//     *
//     * @return void
//     */
//    public function attach(EventManagerInterface $events)
//    {
//        $this->listeners[] = $events->attach(\Zend\View\ViewEvent::EVENT_RENDERER, [$this, 'render'], -999);
//    }
//
//    /**
//     * Detach all previously attached listeners
//     *
//     * @param EventManagerInterface $events
//     *
//     * @return void
//     */
//    public function detach(EventManagerInterface $events)
//    {
//        foreach ($this->listeners as $index => $listener) {
//            if ($events->detach($listener)) {
//                unset($this->listeners[$index]);
//            }
//        }
//    }
//
//    /**
//     * Renders the "twigged" view of a page
//     * whose template type is Twig - "TWG"
//     *
//     * @param MvcEvent $e
//     * @return null|string|\Zend\Stdlib\ResponseInterface
//     */
//    public function render(MvcEvent $e)
//    {
//        $result = $e->getResult();
//        if ($result instanceof Response) {
//            return $result;
//        }
//
//        $viewModel = $e->getViewModel();
//        if (!empty($viewModel) && get_class($viewModel) === self::VIEW_MODEL && $viewModel->getVariables()) {
//            /** Get Page's type of template */
//            $template = $viewModel->getVariables()->offsetGet("pageTemplate") ?? null;
//
//            if (!empty($template) && $template->tpl_type === self::TWIG_TEMPLATE) {
//                $ds = DIRECTORY_SEPARATOR;
//
//                /** Convert CamelCase -> dash-separated-string (i.e. MelisDemoCms -> melis-demo-cms) */
//                $folder = lcfirst($template->tpl_zf2_website_folder);
//                $pieces = preg_split('/(?=[A-Z])/', $folder);
//                $folder = strtolower(implode("-", $pieces));
//
//                $path = getcwd() . $ds . "vendor$ds" . "melisplatform$ds" . "$folder$ds" . "view$ds" . "$folder$ds";
//                $path .= strtolower($template->tpl_zf2_controller) . $ds;
//
//                /** @var Twig_Environment $env */
//                $loader = new FilesystemLoader($path);
//                $env = new Twig_Environment($loader, ['cache' => false]);
//
//                try {
//                    /** Resolve Template extension */
//                    $name = $path . $template->tpl_zf2_action . self::ZF2_EXT;
//                    if (file_exists($name)) {
//                        $name = $template->tpl_zf2_action . self::ZF2_EXT;
//                    } else {
//                        $name = $template->tpl_zf2_action . self::TWG_EXT;
//                    }
//
//                    /** render using Twig */
//                    echo $env->render($name, (array)$viewModel->getVariables());
////                    $result = $env->render($name, (array)$viewModel->getVariables());
////                    die(var_dump($result));
////                    $e->getViewModel()->setVariable(self::TWG, $env);
////                    $e->getResponse()->setContent($result);
////
////                    return $e->getResponse()->getContent();
//                } catch (Exception $error) {
//                    echo $error->getMessage();
//                }
//            }
//        }
//
//        return null;
//    }
//}
