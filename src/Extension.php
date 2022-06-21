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
use Twig\Environment as Twig_Environment;

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
            new TwigFunction('pregMatch', [$this, 'pregMatch']),

            // Place the following in a different extension file called "DeveloperToolsExtension"
            new TwigFunction('xp', [$this, 'executePhp'], ['needs_context' => true, 'needs_environment' => true]),
            new TwigFunction('pp', [$this, 'prettyPrint']), // Pretty Print: print_r()
            new TwigFunction('vd', [$this, 'varDump']),     // Variable Dump: var_dump()
            new TwigFunction('dd', [$this, 'dieDump']),     // Die & Dump: die(var_dump())
        ];
    }

    /**
     * Executes string PHP code using eval()
     *  - Context Variables & Twig Environment is injected for easier usage.
     *
     * @param Twig_Environment $env
     * @param $context
     * @param string $code
     * @return mixed|string
     */
    public function executePhp(Twig_Environment $env, $context, string $code)
    {
        try {
            return eval($code);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * preg_match (
     *  string $pattern ,
     *  string $subject
     *  [array &$matches]
     * ) : int
     *
     * RETURNS:
     * If $pregMatches is NOT supplied (null):
     *      - returns 1 if the pattern matches given subject, 0 if it does not, or FALSE if an error occurred.
     *
     * If $pregMatches is supplied (array):
     *      - then it is filled with the results of search. $matches[0] will contain the text
     *  that matched the full pattern, $matches[1] will have the text that matched the first captured
     *  parenthesized subpattern, and so on.
     *
     *      Ex. {% set pregMatches = pregMatch('/<img\\s.*?\\bsrc="(.*?)".*?>/si', subject, {}) %}
     *
     * source: https://www.php.net/manual/en/function.preg-match.php
     *
     * Gotchas in regex pattern:
     *  - Twig auto-escapes the \ character, fix it by adding another \\ (double escaping)
     * https://craftcms.stackexchange.com/a/4271
     *
     * @param $context
     * @param string $pattern
     * @param string $subject
     * @param null $pregMatches
     * @return false|int
     */
    public function pregMatch(string $pattern, string $subject, $pregMatches = null)
    {
        if (is_array($pregMatches)) {
            preg_match($pattern, $subject, $pregMatches);
            return $pregMatches;
        } else {
            return preg_match($pattern, $subject);
        }
    }

    /**
     * Pretty Prints the data passed
     *
     * @param $data
     */
    public function prettyPrint($data)
    {
        echo "<pre>" . print_r($data, true) . "</pre>";
    }

    /**
     * Uses PHP's var_dump()
     *
     * @param $data
     */
    public function varDump($data)
    {
        echo var_dump($data);
    }

    /**
     * Dumps the passed data & Halts program execution
     *
     * @param $data
     */
    public function dieDump($data)
    {
        die(var_dump($data));
    }
}
