<?php define('PAPERPHP_ROOT' , dirname(__DIR__));

/**
 * PaperPHP
 *
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 * @link https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 */

require PAPERPHP_ROOT . '/vendor/autoload.php';

// load configuration file
$configFile = (file_exists(PAPERPHP_ROOT . '/config.json') ? '/config.json' : '/config.json.default');
if (!file_exists(PAPERPHP_ROOT . $configFile)) {
    exit('<h2>PaperPHP Setup Error</h2>'.
        'Both, "config.json" and "config.json.default" is missing. Please restore one from the original package.');
}
$config = json_decode(file_get_contents(PAPERPHP_ROOT . $configFile));

// parse requested url and translate to relative path
$url = parse_url($_SERVER['REQUEST_URI']);
$requestPath = rtrim($url['path'], '/');
$documentPath = $config->markdown->directory . $requestPath;

// assume "index.md" on directories
if (is_dir(realpath(PAPERPHP_ROOT . $documentPath))) {
    $documentPath .= '/index';
}

// base response array
$response = [
    'documentPath' => $documentPath . $config->markdown->extension,
    'requestPath' => $requestPath,
    'charset' => $config->templates->charset,
    'website' => $config->website
];

// setup template engine
$loader = new Twig_Loader_Filesystem(PAPERPHP_ROOT . $config->templates->directory);
$twig = new Twig_Environment($loader, [
    'charset' => $config->templates->charset,
    'auto_reload' => $config->templates->debug,
    'debug' => $config->templates->debug,
    'cache' => PAPERPHP_ROOT . $config->templates->cache
]);

// handle exceptions
set_exception_handler(function($e) use($twig, $response) {
    $e = error_get_last() ? error_get_last() : func_get_args();
    if (!empty($e) && $e[0] instanceof Exception) {
        $response['errorCode'] = $e[0]->getCode();
        $response['errorMessage'] = $e[0]->getMessage();
        $response['errorLine'] = $e[0]->getLine();
        exit($twig->render('exception.twig', $response));
    }
    return;
});

// lookup markdown file
$filePath = realpath(PAPERPHP_ROOT . $documentPath . $config->markdown->extension);
if (!file_exists($filePath)) {
    exit($twig->render('notfound.twig', $response));
}

// parse markdown
$parser = new Devster\Frontmatter\Parser('yaml', 'markdown');
$frontmatter = $parser->parse(file_get_contents($filePath));
$document = $frontmatter->head;
$content = $frontmatter->getBody();

// render
$template = isset($document['template']) ? $document['template'] : $config->templates->default;
$response = array_merge($response, compact('template', 'document', 'content'));
exit($twig->render($template . '.twig', $response));