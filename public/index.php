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
require PAPERPHP_ROOT . '/vendor/autoload.php';
use \PaperPHP\Paper\Document;
use \PaperPHP\Paper\Template;

/**
 * PaperPHP Main File
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 */

$uri = $_SERVER['REQUEST_URI'];

$document = new Document($uri);
if ($document->parse()) {
    echo $document->render();
} else {
    echo Template::render('notfound', $document->getResponse());
}

exit;
