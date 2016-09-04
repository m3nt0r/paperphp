<?php
/**
 * PaperPHP
 *
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 * @link https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 */
namespace PaperPHP\Paper\Parser;
use Symfony\Component\Yaml\Yaml;

/**
 * PaperPHP Markdown Parser
 *
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 * @link https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 */

class FrontmatterParser extends \Devster\Frontmatter\Parser
{
    public function parseFrontmatter($content)
    {
        $matches = [];
        $delimiter = $this->delimiter;

        $pattern = sprintf(
            "/^\s*(?:%s)[\n\r\s]*(.*?)[\n\r\s]*(?:%s)[\s\n\r]*(.*)$/s",
            $delimiter,
            $delimiter
        );

        $result = preg_match($pattern, $content, $matches);

        $head = isset($matches[1]) ? $matches[1] : null;
        $body = isset($matches[2]) ? $matches[2] : null;

        // this header is always present
        $defaultHeader = [
            'title' => '',
            'description' => '',
        ];

        // it is possible to define an array via config
        $configHeader = Config::get('templates.header');

        // extend the default header with whatever is in there
        if (is_array($configHeader)) {
            $defaultHeader = array_merge($defaultHeader, $configHeader);
        }

        // if the markdown file didn't contain frontmatter for us, use default.
        if (!$result || (is_null($head) && is_null($body)))
        {
            $head = Yaml::dump($defaultHeader);
            $body = $content;
        }

        return array('head' => $head, 'body' => $body);
    }

}