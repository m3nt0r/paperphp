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
use Devster\Frontmatter\Exception\Exception;

/**
 * PaperPHP Document Request/Response
 *
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 * @link https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 */

class Document
{
    private $response;
    private $request;
    private $filepath;

    /**
     * Document constructor.
     *
     * Parse URI and translate to relative path.
     *
     * @param $uri
     */
    public function __construct($uri)
    {
        set_exception_handler(array(&$this, 'handleException'));

        $url = parse_url($uri);

        $requestPath = rtrim($url['path'], '/');
        $documentPath = Config::get('markdown.directory') . $requestPath;

        // assume "index" file if path translates to a directory
        if (is_dir(realpath(PAPERPHP_ROOT . $documentPath))) {
            $documentPath .= '/index';
        }

        $this->filepath = realpath(PAPERPHP_ROOT . $documentPath . Config::get('markdown.extension'));

        $this->request = [
            'path' => $requestPath ? $requestPath : '/',
            'document' => $documentPath . Config::get('markdown.extension')
        ];

        $this->response = [
            'charset' => Config::get('templates.charset'),
            'website' => Config::get('website'),
            'request' => $this->request
        ];
    }


    /**
     * Parse Document File, add Results to Response
     *
     * return boolean False if file not found
     */
    public function parse()
    {
        if (!file_exists($this->filepath)) {
            return false;
        }

        $result = Markdown::parse($this->filepath);

        $document = $result['document'];
        $content = $result['content'];

        $template = isset($document['template']) ? $document['template'] : Config::get('templates.default');
        $this->response = array_merge($this->response, compact('template', 'document', 'content'));

        return true;
    }

    /**
     * Render Markdown File
     *
     * return string HTML
     */
    public function render()
    {
        $template = $this->getResponse('template');

        return Template::render($template, $this->response);
    }

    /**
     * Global exception handling
     *
     * @param $e
     */
    public function handleException($e)
    {
        $e = error_get_last() ? error_get_last() : func_get_args();

        if (!empty($e) && $e[0] instanceof \Exception)
        {
            $this->response['errorCode'] = $e[0]->getCode();
            $this->response['errorMessage'] = $e[0]->getMessage();
            $this->response['errorLine'] = $e[0]->getLine();

            exit(Template::render('exception', $this->getResponse()));
        }
    }

    /**
     * Request Array
     *
     * @param string $key (optional)
     *
     * @return array|mixed|null
     */
    public function getRequest($key = null)
    {
        if ($key) {
            if (!isset($this->response[$key])) {
                return null;
            }
            return $this->request[$key];
        }
        return $this->request;
    }

    /**
     * Response Array
     *
     * @param string $key (optional)
     *
     * @return array|mixed|null
     */
    public function getResponse($key = null)
    {
        if ($key) {
            if (!isset($this->response[$key])) {
                return null;
            }
            return $this->response[$key];
        }
        return $this->response;
    }
}