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
 * PaperPHP Config Reader
 *
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 * @link https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 */

class Config
{
    private static $data = null;

    private static function load()
    {
        $configFile = (file_exists(PAPERPHP_ROOT . '/config.json') ? '/config.json' : '/config.json.default');
        if (!file_exists(PAPERPHP_ROOT . $configFile)) {
            trigger_error('Both, "config.json" and "config.json.default" is missing. Please restore one from the original package.', E_USER_ERROR);
            exit; // we stop here as continuing would be futile anyway
        }
        $configData = file_get_contents(PAPERPHP_ROOT . $configFile);
        self::$data = json_decode($configData, true);
    }

    public static function get($name = null)
    {
        // lazy load config json
        if (null === self::$data) {
            self::load();
        }

        // return everything with empty param
        if (!$name) {
            return self::$data;
        }

        // cheap dot notation support
        $splits = explode('.', $name);
        if (count($splits) == 2)
        {
            $section = $splits[0];
            $key = $splits[1];

            if (isset(self::$data[$section])) {
                if (isset(self::$data[$section][$key])) {
                    return self::$data[$section][$key];
                }
            }
        }
        elseif (isset(self::$data[$name]))
        {
            return self::$data[$name];
        }

        return null;
    }
}