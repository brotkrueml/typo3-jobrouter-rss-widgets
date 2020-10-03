<?php
declare(strict_types=1);

/*
 * This file is part of the "jobrouter_rss_widgets" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\JobRouterRssWidgets\Dashboard\Widgets;

use Brotkrueml\JobRouterRssWidgets\Extension;
use TYPO3\CMS\Dashboard\Widgets\AdditionalCssInterface;
use TYPO3\CMS\Dashboard\Widgets\RequireJsModuleInterface;

/**
 * @internal
 */
class VideoRssWidget extends AbstractMediaRssWidget implements RequireJsModuleInterface, AdditionalCssInterface
{
    public function getTemplate(): string
    {
        return 'Widget/VideoRssWidget';
    }

    protected function generateRssItems(\SimpleXMLElement $rssFeed): array
    {
        $items = [];
        foreach ($rssFeed->channel->item as $item) {
            $media = $item->children('http://search.yahoo.com/mrss/')->content;

            $items[] = [
                'title' => \trim((string)$item->title),
                'link' => (string)$item->link,
                'pubDate' => \trim((string)$item->pubDate),
                'description' => \trim(\strip_tags((string)$item->description)),
                'media' => $media,
                'videoEmbedUrl' => (string)$media->player->attributes()['url'],
            ];
        }
        \usort($items, static function (array $item1, array $item2): int {
            return new \DateTime($item2['pubDate']) <=> new \DateTime($item1['pubDate']);
        });
        $items = \array_slice($items, 0, $this->options->getLimit());

        foreach ($items as &$item) {
            $item['image'] = $this->getImage($item['media']->thumbnail ?? []);
            unset($item['media']);
        }

        return $items;
    }

    protected function getImageInformation($thumbnails): array
    {
        $image = null;
        foreach ($thumbnails as $thumbnail) {
            $image = (string)$thumbnail->attributes()['url'];

            $ratio = (int)$thumbnail->attributes()['width'] / (int)$thumbnail->attributes()['height'];
            if ($ratio > 1.7) {
                // 16:9
                break;
            }
        }

        return [$image, null];
    }

    public function getRequireJsModules(): array
    {
        return [
            'TYPO3/CMS/JobrouterRssWidgets/Video',
        ];
    }

    public function getCssFiles(): array
    {
        return [
            \sprintf('EXT:%s/Resources/Public/Css/video.css', Extension::KEY),
        ];
    }
}
