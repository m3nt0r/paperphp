<?php
/**
 * PaperPHP
 *
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 * @link https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 */
define('PAPERPHP_ROOT', dirname(__DIR__));

// check if we get the required url parameter (from rewrite)
if (isset($_GET['url'])) {
    $path = '/' . ltrim($_GET['url'], '/');
} else {
    $path = '/';
}

// prevent files that aren't always present, but requested by some clients anyway
if (isset($_GET['url']) && in_array($_GET['url'], ['robots.txt', 'favicon.ico'])) {
    header('HTTP/1.1 404 Not Found');
    exit;
}

/**
 * PaperPHP Main File
 *  Load Document from URL
 */
require PAPERPHP_ROOT . '/vendor/autoload.php';

$document = new \PaperPHP\Paper\Document($path);

if ($document->parse())
{
    echo $document->render();
}
else
{
    echo \PaperPHP\Paper\Template::render('notfound', $document->getResponse());
}

exit;
