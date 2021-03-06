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

use Laminas\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $environmentLoader;

    /**
     * @var string
     */
    protected $environmentClass;

    /**
     * @var array
     */
    protected $environmentOptions = [];

    /**
     * @var array
     */
    protected $globals = [];

    /**
     * @var array
     */
    protected $loaderChain = [];

    /**
     * @var array
     */
    protected $extensions = [];

    /**
     * @var string
     */
    protected $suffix;

    /**
     * @var bool
     */
    protected $enableFallbackFunctions = true;

    /**
     * @var bool
     */
    protected $enableTwigModel = true;

    /**
     * @var array
     */
    protected $helperManager = [];

    /**
     * @return boolean
     */
    public function getEnableTwigModel()
    {
        return $this->enableTwigModel;
    }

    /**
     * @param $enableTwigModel
     * @return $this
     */
    public function setEnableTwigModel($enableTwigModel)
    {
        $this->enableTwigModel = $enableTwigModel;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getEnableFallbackFunctions()
    {
        return $this->enableFallbackFunctions;
    }

    /**
     * @param $enableFallbackFunctions
     * @return $this
     */
    public function setEnableFallbackFunctions($enableFallbackFunctions)
    {
        $this->enableFallbackFunctions = $enableFallbackFunctions;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnvironmentLoader()
    {
        return $this->environmentLoader;
    }

    /**
     * @param $environmentLoader
     * @return $this
     */
    public function setEnvironmentLoader($environmentLoader)
    {
        $this->environmentLoader = $environmentLoader;
        return $this;
    }

    /**
     * @return array
     */
    public function getEnvironmentOptions()
    {
        return $this->environmentOptions;
    }

    /**
     * @param $environmentOptions
     * @return $this
     */
    public function setEnvironmentOptions($environmentOptions)
    {
        $this->environmentOptions = $environmentOptions;
        return $this;
    }

    /**
     * @return array
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * @param $extensions
     * @return $this
     */
    public function setExtensions($extensions)
    {
        $this->extensions = $extensions;
        return $this;
    }

    /**
     * @return array
     */
    public function getHelperManager()
    {
        return $this->helperManager;
    }

    /**
     * @param $helperManager
     * @return $this
     */
    public function setHelperManager($helperManager)
    {
        $this->helperManager = $helperManager;
        return $this;
    }

    /**
     * @return array
     */
    public function getLoaderChain()
    {
        return $this->loaderChain;
    }

    /**
     * @param $loaderChain
     * @return $this
     */
    public function setLoaderChain($loaderChain)
    {
        $this->loaderChain = $loaderChain;
        return $this;
    }

    /**
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @param $suffix
     * @return $this
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnvironmentClass()
    {
        return $this->environmentClass;
    }

    /**
     * @param string $environmentClass
     */
    public function setEnvironmentClass($environmentClass)
    {
        $this->environmentClass = $environmentClass;
    }

    /**
     * @return array
     */
    public function getGlobals()
    {
        return $this->globals;
    }

    /**
     * @param array $globals
     */
    public function setGlobals($globals)
    {
        $this->globals = $globals;
    }
}
