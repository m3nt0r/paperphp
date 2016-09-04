<?php
/**
 * PaperPHP
 *
 * @author Kjell Bublitz <kjbbtz@gmail.com>
 * @link https://github.com/paperphp/paperphp GitHub
 * @license MIT
 * @package paperphp
 */
define('PAPERPHP_ROOT', dirname(__DIR__));
require PAPERPHP_ROOT . '/vendor/autoload.php';

use PaperPHP\Paper\Config;
use PaperPHP\Paper\Paper;
use PaperPHP\Paper\Markdown;

/**
 * PaperPHP RSS Feed
 *
 * @todo We need to collect only relevant files in the future (by date and limit).
 */

// vars
$items = [];
$lastBuildDate = time();
$orderBy = Config::get('rss.orderby');
$charLimit = Config::get('rss.truncate');
$itemLimit = Config::get('rss.limit');
$baseUrl = Paper::getBaseUrl();

// collect documents
if (!Paper::noIndexFile()) {

    $timestampedItems = [];
    $websiteAuthor = Config::get('website.author');

    foreach (Paper::getMarkdownFilepaths() as $filepath) {
        $created = filectime($filepath);
        $modified = filemtime($filepath);
        $time = ($orderBy == 'modified' ? $modified : $created);

        if ($lastBuildDate < $modified) {
            $lastBuildDate = $modified;
        }

        $result = Markdown::parse($filepath);
        $link = $baseUrl . Paper::filepathToUri($filepath);
        $title = $result['document']['title'] ? $result['document']['title'] : basename($filepath);
        $creator = isset($result['document']['author']) ? $result['document']['author'] : $websiteAuthor;

        $content = '';
        if (!empty($result['content']) && strlen($result['content']) > 1) {
            $content = $charLimit ? substr(strip_tags($result['content']), 0, $charLimit) . '...' : $result['content'];
        }

        $item = "\t";
        $item.= '<item>' . "\n\t\t";
        $item.= '<title>' . $title .'</title>' .  "\n\t\t";
        if ($creator) { $item.= '<dc:creator><![CDATA['. $creator .']]></dc:creator>' .  "\n\t\t"; }
        $item.= '<link>' . $link .'</link>' .  "\n\t\t";
        $item.= '<guid isPermaLink="true">'. $link .'</guid>' .  "\n\t\t";
        $item.= '<pubDate>'. date('c', $created) . '</pubDate>' . "\n\t\t";
        $item.= '<description><![CDATA['. $content .']]></description>' .  "\n\t";
        $item.= '</item>' . "\n";

        // add item by "last-modified"
        if (!isset($timestampedItems[$time]))
            $timestampedItems[$time] = [];

        array_push($timestampedItems[$time], $item);
    }

    // sort indexed array
    krsort($timestampedItems, SORT_NUMERIC);

    // make items one-dimensional again
    // they were multidimensional to allow multiple files to share the same date.
    foreach ($timestampedItems as $timestamp => $documents) {
        if (sizeof($items) === $itemLimit)
            break;

        foreach ($documents as $item) {
            $items[]= $item;

            if (sizeof($items) === $itemLimit)
                break;
        }
    }
}

// tell them we deliver XML.
$charset = strtolower(Config::get('website.charset'));
header("Content-Type: application/xml; charset=" . $charset);
echo '<?xml version="1.0" encoding="' . $charset . '"?>';
?>

<rss version="2.0"
   xmlns:content="http://purl.org/rss/1.0/modules/content/"
   xmlns:wfw="http://wellformedweb.org/CommentAPI/"
   xmlns:dc="http://purl.org/dc/elements/1.1/"
   xmlns:atom="http://www.w3.org/2005/Atom"
   xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
   xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
>
<channel>
    <title><?php echo Config::get('website.name'); ?></title>
    <link><?php echo $baseUrl . $_SERVER['REQUEST_URI']; ?></link>
    <description><?php echo Config::get('website.description'); ?></description>
    <lastBuildDate><?php echo date('c', $lastBuildDate); ?></lastBuildDate>
    <language><?php echo Config::get('website.language'); ?></language>
    <sy:updatePeriod>hourly</sy:updatePeriod>
    <sy:updateFrequency>1</sy:updateFrequency>
    <generator>https://github.com/paperphp/paperphp</generator>
<?php echo join("\n", $items); ?>
</channel>
</rss>