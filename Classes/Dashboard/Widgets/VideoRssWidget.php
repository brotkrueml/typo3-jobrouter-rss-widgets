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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Dashboard\Widgets\AdditionalCssInterface;
use TYPO3\CMS\Dashboard\Widgets\RequireJsModuleInterface;

/**
 * @internal
 */
class VideoRssWidget extends AbstractMediaRssWidget implements RequireJsModuleInterface, AdditionalCssInterface
{
    public function renderWidgetContent(): string
    {
        $this->view->setTemplate('Widget/VideoRssWidget');
        $this->view->assignMultiple([
            'items' => $this->getRssItems(),
            'options' => $this->options,
            'button' => $this->buttonProvider,
            'configuration' => $this->configuration,
        ]);
        return $this->view->render();
    }

    protected function getRssItems(): array
    {
        $cacheHash = \md5(static::class . $this->options['feedUrl']);
        if ($items = $this->cache->get($cacheHash)) {
            return $items;
        }

        $rssContent = GeneralUtility::getUrl($this->options['feedUrl']);
        if ($rssContent === false) {
            throw new \RuntimeException('RSS URL could not be fetched', 1588604410);
        }
        $rssFeed = \simplexml_load_string($rssContent);
        $items = [];
        foreach ($rssFeed->channel->item as $item) {
            $media = $item->children('http://search.yahoo.com/mrss/')->content;

            $items[] = [
                'title' => \trim((string)$item->title),
                'link' => $this->changeUtmParameter((string)$item->link),
                'pubDate' => \trim((string)$item->pubDate),
                'description' => \trim(\strip_tags((string)$item->description)),
                'media' => $media,
                'videoEmbedUrl' => (string)$media->player->attributes()['url'],
            ];
        }
        \usort($items, static function ($item1, $item2) {
            return new \DateTime($item2['pubDate']) <=> new \DateTime($item1['pubDate']);
        });
        $items = \array_slice($items, 0, $this->options['limit']);

        foreach ($items as &$item) {
            $item['image'] = $this->getImage($item['media']->thumbnail ?? []);
            unset($item['media']);
        }

        $this->cache->set($cacheHash, $items, ['dashboard_rss'], $this->options['lifeTime']);

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
