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
    private $request = [];
    private $response = [];
    private $template = '';

    /**
     * @var bool|string
     */
    private $filepath = false;

    /**
     * Document constructor.
     *
     * Parse URI and translate to relative path.
     *
     * @param $path
     */
    public function __construct($path)
    {
        // show fancy exceptions
        set_exception_handler(array(&$this, 'handleException'));

        // get markdown options
        $markdownPath = Config::get('markdown.directory');
        $markdownExt = Config::get('markdown.extension');

        if (Paper::noIndexFile()) {
            // show "welcome" pages
            $markdownPath = '/frontend/md';
            $markdownExt = '.md';
        }

        // build partial path
        $requestPath = rtrim($path, '/');
        $documentPath = $markdownPath . $requestPath;

        // assume "index" file if path translates to a directory
        if (is_dir(realpath(PAPERPHP_ROOT . $documentPath))) {
            $documentPath .= '/index';
        }

        // full path to markdown file or false
        $this->filepath = realpath(PAPERPHP_ROOT . $documentPath . $markdownExt);

        // request information for file processing (and perhaps templates)
        $this->request = [
            'path' => $requestPath ? $requestPath : '/',
            'document' => $documentPath . $markdownExt
        ];

        // start response array for templates
        $this->response = [
            'lang' => Config::get('website.language'),
            'charset' => Config::get('website.charset'),
            'website' => Config::get('website'),
            'rssfeed' => Paper::getBaseUrl() . '/rss.php',
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

        $this->template = $template = isset($document['template']) ? $document['template'] : Config::get('templates.default');
        $this->response = array_merge($this->response, compact('document', 'content', 'template'));

        return true;
    }

    /**
     * Render Markdown File
     *
     * return string HTML
     */
    public function render()
    {
        return Template::render($this->template, $this->response);
    }

    /**
     * Render Not-Found template
     *
     * return string HTML
     */
    public function notfound()
    {
        return Template::render('notfound', $this->response);
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

    /**
     * @return string Name of the template to use
     */
    public function getTemplate()
    {
        return $this->template;
    }
}