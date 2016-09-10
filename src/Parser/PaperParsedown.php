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
 * PaperPHP Custom Parsedown
 *
 * This adds extra features to the standard Markdown parser.
 *
 * Added shortcuts:
 *
 *  "%[]"  Adding a percent-sign in front of a youtube link, wrapped in brackets,
 *         will convert it to an iframe embed.
 *
 *         Example: %[ http://youtube.. ]
 *
 *
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 * @link https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 * @subpackage parser
 */
class PaperParsedown extends \ParsedownExtra
{
    const version = '0.1.0';

    function __construct()
    {
        parent::__construct();

        $this->BlockTypes['%'] = array('YouTubeFrame');
    }

    /**
     * Youtube Iframe
     *
     * @todo Refactor to support multiple video sites. Vimeo, etc..
     *
     * @param array $line
     *
     * @return array|void
     */
    protected function blockYouTubeFrame($line)
    {
        if (!isset($line['text'][1]) || $line['text'][0] !== '%' || $line['text'][1] !== '[')
        {
            return;
        }

        $withoutPrefix = substr($line['text'], 1);
        $withoutBrackets = trim($withoutPrefix, '[]');

        $href = trim( $withoutBrackets ); // whitespace between brackets is allowed

        // detect youtube ID
        $matches = [];
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $href, $matches);

        if (empty($matches))
        {
            return;
        }

        $iframeSrc = '//www.youtube-nocookie.com/embed/' . $matches[0] . '?rel=0&amp;controls=0&amp;showinfo=0';


        $Block = array(
            'element' => array(
                'name' => 'div',
                'handler' => 'element',
                'attributes' => array(
                    'class' => 'video-embed',
                    'data-href' => $href,
                ),
                'text' => array(
                    'name' => 'iframe',
                    'text' => '',
                    'attributes' => array(
                        'src' => $iframeSrc,
                        'class' => 'video video-youtube',
                        'frameborder' => '0',
                        'width' => '100%',
                        'allowfullscreen' => ''
                    ),
                ),

            ),
        );

        return $Block;
    }
}