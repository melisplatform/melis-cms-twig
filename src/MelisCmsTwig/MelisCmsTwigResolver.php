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
use Zend\View\Renderer\RendererInterface;
use Zend\View\Resolver\ResolverInterface;

class MelisCmsTwigResolver implements ResolverInterface
{
    /**
     * @var Twig_Environment
     */
    protected $environment;

    /**
     * MelisCmsTwigResolver constructor.
     *
     * @param Twig_Environment $environment
     */
    public function __construct(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Resolve a template/pattern name to a resource the renderer can consume
     * @param string $name
     * @param RendererInterface|null $renderer
     * @return \Twig\Template
     */
    public function resolve($name, RendererInterface $renderer = null)
    {
        return $this->environment->loadTemplate($name);
    }
}
