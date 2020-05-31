<?php
declare(strict_types=1);

/*
 * This file is part of the "jobrouter_rss_widgets" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\JobRouterRssWidgets\Dashboard\Widgets;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @internal
 */
class PictureRssWidget extends AbstractMediaRssWidget
{
    public function renderWidgetContent(): string
    {
        $this->view->setTemplate('Widget/PictureRssWidget');
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
            throw new \RuntimeException('RSS URL could not be fetched', 1588345468);
        }
        $rssFeed = \simplexml_load_string($rssContent);
        $items = [];
        foreach ($rssFeed->channel->item as $item) {
            $items[] = [
                'title' => \trim((string)$item->title),
                'link' => $this->changeUtmParameter((string)$item->link),
                'pubDate' => \trim((string)$item->pubDate),
                'description' => \trim(\strip_tags((string)$item->description)),
                'originalDescription' => (string)$item->description,
            ];
        }
        \usort($items, static function ($item1, $item2) {
            return new \DateTime($item2['pubDate']) <=> new \DateTime($item1['pubDate']);
        });
        $items = \array_slice($items, 0, $this->options['limit']);

        foreach ($items as &$item) {
            $item['image'] = $this->getImage($item['originalDescription']);
            unset($item['originalDescription']);
        }

        $this->cache->set($cacheHash, $items, ['dashboard_rss'], $this->options['lifeTime']);

        return $items;
    }

    protected function getImageInformation($description): array
    {
        if (!\preg_match('/<img src="(.*?)".*alt="(.*?)"/s', $description, $matches)) {
            return [null, null];
        }

        return [$matches[1], $matches[2]];
    }
}
