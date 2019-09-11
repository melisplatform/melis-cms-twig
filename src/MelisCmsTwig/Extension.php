<?php
/**
 * Melis Technology (http://www.melistechnology.com)
 *
 * @copyright Copyright (c) 2019 Melis Technology (http://www.melistechnology.com)
 *
 */

namespace MelisCmsTwig;


use Exception;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig_Environment;

/**
 * Class Extension
 *  - Custom functions that cannot be catered by Twig are implemented here.
 * See example function "xp" a.k.a "Execute Php".
 *
 * 'needs_environment' => true // to access the current environment instance inside the custom function
 * 'needs_context' => true // to access the current context instance inside the custom function
 *
 * @package MelisCmsTwig
 */
class Extension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('xp', [$this, 'executePhp'], ['needs_context' => true, 'needs_environment' => true]),
        ];
    }

    /**
     * Executing string PHP code using eval()
     *
     * @param Twig_Environment $env
     * @param string $code
     * @return mixed
     */
    public function executePhp(Twig_Environment $env, string $code)
    {
        try {
            return eval($code);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}
