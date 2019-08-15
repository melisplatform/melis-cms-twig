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


use Twig\Error\LoaderError as LoaderError;
use Twig\Loader\LoaderInterface as Twig_LoaderInterface;
use Twig\Source;

class MapLoader implements Twig_LoaderInterface
{
    /**
     * Array of templates to filenames.
     * @var array
     */
    protected $map = array();

    /**
     * Returns the source context for a given template logical name.
     *
     * @param string $name The template logical name
     *
     * @return Source
     *
     * @throws LoaderError When $name is not found
     */
    public function getSourceContext($name)
    {
        if (!$this->exists($name)) {
            throw new LoaderError(sprintf(
                'Unable to find template "%s" from template map',
                $name
            ));
        }

        if (!file_exists($this->map[$name])) {
            throw new LoaderError(sprintf(
                'Unable to open file "%s" from template map',
                $this->map[$name]
            ));
        }

        return new Source(file_get_contents($this->map[$name]), $name, $this->map[$name]);
    }

    /**
     * Check if we have the source code of a template, given its name.
     *
     * @param string $name The name of the template to check if we can load
     *
     * @return bool If the template source code is handled by this loader or not
     */
    public function exists($name)
    {
        return array_key_exists($name, $this->map);
    }

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The cache key
     *
     * @throws LoaderError When $name is not found
     */
    public function getCacheKey($name)
    {
        return $name;
    }

    /**
     * Returns true if the template is still fresh.
     *
     * @param string $name The template name
     * @param int $time Timestamp of the last modification time of the
     *                     cached template
     *
     * @return bool true if the template is fresh, false otherwise
     *
     * @throws LoaderError When $name is not found
     */
    public function isFresh($name, $time)
    {
        return filemtime($this->map[$name]) <= $time;
    }

    /**
     * Add to the map.
     *
     * @param string $name
     * @param string $path
     * @throws LoaderError
     * @return MapLoader
     */
    public function add($name, $path)
    {
        if ($this->exists($name)) {
            throw new LoaderError(sprintf(
                'Name "%s" already exists in map',
                $name
            ));
        }
        $this->map[$name] = $path;

        return $this;
    }
}
