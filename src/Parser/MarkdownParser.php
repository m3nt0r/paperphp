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

/**
 * PaperPHP Markdown Parser for Frontmatter
 *
 * This overwrites the default and uses our "PaperParsedown" instead of just "ParsedownExtra"
 *
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 * @link https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 * @subpackage parser
 */
class MarkdownParser extends \Devster\Frontmatter\Parser\Parser
{
    /**
     * @var ParsedownExtra
     */
    protected $parsedown;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->parsedown = new PaperParsedown();
    }

    /**
     * {@inheritdoc}
     */
    public function parse($content)
    {
        return $this->parsedown->text($content);
    }
}
