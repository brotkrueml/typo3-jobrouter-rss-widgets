<?php
declare(strict_types=1);

/*
 * This file is part of the "jobrouter_rss_widgets" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\JobRouterRssWidgets\Dashboard\Widgets;

/**
 * @internal
 */
class PictureRssWidget extends AbstractMediaRssWidget
{
    public function getTemplate(): string
    {
        return 'Widget/PictureRssWidget';
    }

    protected function generateRssItems(\SimpleXMLElement $rssFeed): array
    {
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
        \usort($items, static function (array $item1, array $item2): int {
            return new \DateTime($item2['pubDate']) <=> new \DateTime($item1['pubDate']);
        });
        $items = \array_slice($items, 0, $this->options['limit']);

        foreach ($items as &$item) {
            $item['image'] = $this->getImage($item['originalDescription']);
            unset($item['originalDescription']);
        }

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
