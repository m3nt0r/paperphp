<?php
/**
 * PaperPHP
 *
 * @author  Kjell Bublitz <kjbbtz@gmail.com>
 * @link    https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 */
namespace PaperPHP\Paper;

use PaperPHP\Paper\Parser\FrontmatterParser;

/**
 * PaperPHP Core Functions
 *
 * @author  Kjell Bublitz <kjbbtz@gmail.com>
 * @link    https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 */
class Paper
{
    public static function noIndexFile()
    {
        $markdownPath = Config::get('markdown.directory');
        $markdownExt = Config::get('markdown.extension');

        return (!realpath(
            PAPERPHP_ROOT . $markdownPath . '/index' . $markdownExt
        ));
    }

    public static function getMarkdownFilepaths()
    {
        $markdownPath = Config::get('markdown.directory');
        $markdownExt = Config::get('markdown.extension');
        $filepaths = [];

        if ($folder = realpath(PAPERPHP_ROOT . $markdownPath)) {
            foreach (glob($folder . '/*' . $markdownExt) as $filename) {
                $filepaths[] = $filename;
            }
        }
        return $filepaths;
    }

    public static function filepathToUri($filepath)
    {
        $markdownPath = Config::get('markdown.directory');
        $markdownExt = Config::get('markdown.extension');

        return str_replace(
            [PAPERPHP_ROOT, $markdownPath, $markdownExt], '', $filepath
        );
    }

    public static function uriToFilepath($uri)
    {
        $markdownPath = Config::get('markdown.directory');
        $markdownExt = Config::get('markdown.extension');

        // make sure path begins with a forward slash
        if ($uri{0} !== '/') {
            $uri = '/' . $uri;
        }

        return realpath(
            PAPERPHP_ROOT . $markdownPath . $uri . $markdownExt
        );
    }

    public static function getBaseUrl()
    {
        $domain = $_SERVER['HTTP_HOST'];

        $ssl = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1));
        $sslProxy = (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https');

        $protocol = ($ssl || $sslProxy) ? 'https' : 'http';

        return $protocol . '://' . $domain;
    }
}