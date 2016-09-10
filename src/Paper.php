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

/**
 * PaperPHP Core
 *
 * @author  Kjell Bublitz <kjbbtz@gmail.com>
 * @link    https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 */
class Paper
{

    /**
     * Returns false if the markdown directory doesn't have an "index.md"
     *
     * @return false|string
     */
    public static function noIndexFile()
    {
        $markdownPath = Config::get('markdown.directory');
        $markdownExt = Config::get('markdown.extension');

        return (!realpath(
            PAPERPHP_ROOT . $markdownPath . '/index' . $markdownExt
        ));
    }

    /**
     * Returns an list of absolute filepaths to every markdown file
     *
     * @return array
     */
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

    /**
     * Converts a filepath into a relative path, excluding the extension.
     *
     * @param string $filepath
     *
     * @return string Path that should be part of the URI
     */
    public static function filepathToUri($filepath)
    {
        $markdownPath = Config::get('markdown.directory');
        $markdownExt = Config::get('markdown.extension');

        return str_replace(
            [PAPERPHP_ROOT, $markdownPath, $markdownExt], '', $filepath
        );
    }

    /**
     * Converts a URI into a filepath. It will either return the absolute path or false
     *
     * @param string $uri
     *
     * @return false|string
     */
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

    /**
     * Returns HOST_NAME with current HTTP scheme as string
     *
     * @return string http(s)://hostname
     */
    public static function getBaseUrl()
    {
        $domain = $_SERVER['HTTP_HOST'];

        $ssl = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1));
        $sslProxy = (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https');

        $protocol = ($ssl || $sslProxy) ? 'https' : 'http';

        return $protocol . '://' . $domain;
    }
}