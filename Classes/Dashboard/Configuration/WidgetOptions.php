<?php
declare(strict_types=1);

/*
 * This file is part of the "jobrouter_rss_widgets" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\JobRouterRssWidgets\Dashboard\Configuration;

/**
 * @internal
 * @psalm-immutable
 */
final class WidgetOptions
{
    /**
     * @var string
     */
    private $feedUrl = '';

    /**
     * @var int
     */
    private $limit = 5;

    /**
     * @var int
     */
    private $lifeTime = 43200;

    /**
     * @var int
     */
    private $imageWidth = 100;

    public function __construct(array $options)
    {
        if ($this->isUrl($options['feedUrl'] ?? '')) {
            $this->feedUrl = $options['feedUrl'];
        }

        if (isset($options['limit']) && $this->isPositiveInteger($options['limit'])) {
            $this->limit = $options['limit'];
        }

        if (isset($options['lifeTime']) && $this->isPositiveInteger($options['lifeTime'])) {
            $this->lifeTime = $options['lifeTime'];
        }

        if (isset($options['imageWidth']) && $this->isPositiveInteger($options['imageWidth'])) {
            $this->imageWidth = $options['imageWidth'];
        }
    }

    private function isUrl(string $url): bool
    {
        if (\filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
            return true;
        }

        throw new \InvalidArgumentException(
            \sprintf(
                'The option "feedUrl" was not defined or is not a valid URL, "%s" given',
                $url
            ),
            1590918307
        );
    }

    private function isPositiveInteger(int $value): bool
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException(
                \sprintf(
                    'An option must be a positive integer, "%s" given',
                    $value
                ),
                1590917577
            );
        }

        return true;
    }

    public function getFeedUrl(): string
    {
        return $this->feedUrl;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getLifeTime(): int
    {
        return $this->lifeTime;
    }

    public function getImageWidth(): int
    {
        return $this->imageWidth;
    }
}
