<?php
/**
 * Melis Technology (http://www.melistechnology.com)
 *
 * @copyright Copyright (c) 2019 Melis Technology (http://www.melistechnology.com)
 *
 * Patterned using ZendFramework-Commons ZfcTwig @link https://github.com/ZF-Commons/ZfcTwig
 *
 */

namespace MelisCmsTwig;


use Twig\Environment as Twig_Environment;
use Twig\Loader\ChainLoader as Twig_Loader_Chain;
use Zend\View\Exception;
use Zend\View\HelperPluginManager;
use Zend\View\Model\ModelInterface;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Renderer\TreeRendererInterface;
use Zend\View\Resolver\ResolverInterface;
use Zend\View\View;

class Renderer implements RendererInterface, TreeRendererInterface
{
    /**
     * @var  $environment
     * @var Twig_Loader_Chain $loader
     * @var Resolver $resolver
     * @var View $view
     * @var bool $canRenderTrees
     * @var HelperPluginManager
     */
    protected $environment;
    protected $loader;
    protected $resolver;
    protected $view;
    protected $canRenderTrees = true;
    protected $helperPluginManager;

    /**
     * @var array Cache for the plugin call
     */
    private $__pluginCache = [];

    public function __construct(
        View $view,
        Twig_Loader_Chain $loader,
        Twig_Environment $environment,
        Resolver $resolver
    )
    {
        $this->environment = $environment;
        $this->loader = $loader;
        $this->resolver = $resolver;
        $this->view = $view;
    }

    /**
     * Set the resolver used to map a template name to a resource the renderer may consume.
     *
     * @param ResolverInterface $resolver
     * @return Renderer
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;

        return $this;
    }

    /**
     * Return the template engine object, if any
     *
     * If using a third-party template engine, such as Smarty, patTemplate,
     * phplib, etc, return the template engine object. Useful for calling
     * methods on these objects, such as for setting filters, modifiers, etc.
     *
     * @return mixed
     */
    public function getEngine()
    {
        return $this->environment;
    }

    /**
     * Processes a view script and returns the output
     *
     * @param string|ModelInterface $nameOrModel
     * @param null $values
     * @return null|string
     */
    public function render($nameOrModel, $values = null)
    {
        $model = null;

        if ($nameOrModel instanceof ModelInterface) {
            $model = $nameOrModel;
            $nameOrModel = $model->getTemplate();

            if (empty($nameOrModel)) {
                throw new Exception\DomainException(sprintf(
                    '%s: received View Model argument, but template is empty', __METHOD__
                ));
            }

            $values = (array)$model->getVariables();
        }

        if (!$this->canRender($nameOrModel)) {
            return null;
        }

        /** @var \Twig\Template $template */
        $template = $this->resolver->resolve($nameOrModel, $this);

        return $template->render((array)$values);
    }

    /**
     * Can the template be rendered?
     *
     * @param $name
     * @return bool|mixed
     */
    public function canRender($name)
    {
        return $this->loader->exists($name);
    }

    /**
     * @return boolean
     */
    public function canRenderTrees()
    {
        return $this->canRenderTrees;
    }

    /**
     * @param boolean $canRenderTrees
     * @return Renderer
     */
    public function setCanRenderTrees($canRenderTrees)
    {
        $this->canRenderTrees = $canRenderTrees;

        return $this;
    }

    /**
     * @return HelperPluginManager
     */
    public function getHelperPluginManager()
    {
        return $this->helperPluginManager;
    }

    /**
     * @param HelperPluginManager $helperPluginManager
     * @return Renderer
     */
    public function setHelperPluginManager(HelperPluginManager $helperPluginManager)
    {
        $helperPluginManager->setRenderer($this);
        $this->helperPluginManager = $helperPluginManager;

        return $this;
    }

}
