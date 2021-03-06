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
use PaperPHP\Paper\Parser\FrontmatterParser;

/**
 * PaperPHP Markdown Tools
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

        $parser = new FrontmatterParser('yaml', 'markdown');
        $parser->addParser(new \PaperPHP\Paper\Parser\Markdown);
        $result = $parser->parse($markdownString);

        $document = $result->head;
        $content = $result->getBody();

        return compact('document', 'content');
    }

}