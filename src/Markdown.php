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
 * PaperPHP Markdown Parser
 *
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 * @link https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 */

class Markdown
{
    /**
     * Parse markdown file
     *
     * @param string $filepath
     *
     * @return array [array document, string content]
     */
    public static function parse($filepath)
    {
        $markdownString = file_get_contents($filepath);

        $parser = new Parser('yaml', 'markdown');
        $parser->addParser(new \PaperPHP\Paper\Parser\Markdown);
        $result = $parser->parse($markdownString);

        $document = $result->head;
        $content = $result->getBody();

        return compact('document', 'content');
    }

}