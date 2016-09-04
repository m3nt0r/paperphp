<?php
/**
 * PaperPHP
 *
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 * @link https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 */
namespace PaperPHP\Paper;

/**
 * PaperPHP Template Renderer
 *
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 * @link https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 */

class Template
{

    /**
     * @var \Twig_Environment
     */
    private static $twig = null;

    /**
     * Setup Twig Environment and assign to $twig
     */
    private static function instantiateTwig()
    {
        $loader = new \Twig_Loader_Filesystem(PAPERPHP_ROOT . Config::get('templates.directory'));
        self::$twig = new \Twig_Environment($loader, [
            'charset' => Config::get('website.charset'),
            'auto_reload' => Config::get('templates.debug'),
            'debug' => Config::get('templates.debug'),
            'cache' => PAPERPHP_ROOT . Config::get('templates.cache')
        ]);
    }

    /**
     * Render template
     *
     * @param string $templateName
     * @param array $data
     *
     * @return string
     */
    public static function render($templateName, $data = [])
    {
        if (null === self::$twig) {
            self::instantiateTwig();
        }

        return self::$twig->render($templateName . '.twig', $data);
    }

}