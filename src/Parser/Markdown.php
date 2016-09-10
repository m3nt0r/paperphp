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
 * PaperPHP Parser Meta for Frontmatter
 *
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 * @link https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 * @subpackage parser
 */
class Markdown extends \Devster\Frontmatter\Parser\MetaParser
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'markdown';
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return array('md', 'MD');
    }
}
