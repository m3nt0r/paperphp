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
 *  "+"    Adding a plus-sign in front of a youtube link will create an iframe embed.
 *         Example: +http://youtube..
 *
 *
 *
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 * @link https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 */
class PaperParsedown extends \ParsedownExtra
{
    const version = '0.1.0';

    function __construct()
    {
        parent::__construct();

        $this->BlockTypes['+'] = array('YouTubeFrame');
        $this->unmarkedBlockTypes[]= 'YouTubeFrame';
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
        if ( ! isset($line['text'][1]) or $line['text'][0] !== '+')
        {
            return;
        }

        $youtubeUrl = substr($line['text'], 1);

        // detect youtube ID
        $matches = [];
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $youtubeUrl, $matches);

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
                    'class' => 'video-embed'
                ),
                'text' => array(
                    'name' => 'iframe',
                    'text' => '',
                    'attributes' => array(
                        'src' => $iframeSrc,
                        'class' => 'video video-youtube',
                        'data-original' => $youtubeUrl,
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