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
     */
    protected $environment;
    protected $loader;
    protected $resolver;
    protected $view;
    protected $canRenderTrees = true;

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
     * @param  ResolverInterface $resolver
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

        if ($model && $this->canRenderTrees() && $model->hasChildren()) {
            if (!isset($values['content'])) {
                $values['content'] = '';
            }

            foreach ($model as $child) {
                /** @var \Zend\View\Model\ViewModel $child */
                if ($this->canRender($child->getTemplate())) {
                    $template = $this->resolver->resolve($child->getTemplate(), $this);

                    return $template->render((array)$child->getVariables());
                }

                $child->setOption('has_parent', true);
                $values['content'] .= $this->view->render($child);
            }
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
}
