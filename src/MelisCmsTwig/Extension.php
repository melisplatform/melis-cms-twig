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

class Extension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('xp',[$this, 'executePhp'], ['needs_environment' => true, ]),
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
