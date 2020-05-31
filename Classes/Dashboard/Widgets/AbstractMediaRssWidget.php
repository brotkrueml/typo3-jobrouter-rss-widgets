<?php
declare(strict_types=1);

/*
 * This file is part of the "jobrouter_rss_widgets" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\JobRouterRssWidgets\Dashboard\Widgets;

use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface as Cache;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Imaging\GraphicalFunctions;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Dashboard\Widgets\ButtonProviderInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * @internal
 */
abstract class AbstractMediaRssWidget implements WidgetInterface
{
    protected const UPLOADS_DIR = 'typo3temp/assets/tx_jobrouterrsswidgets';

    /**
     * @var WidgetConfigurationInterface
     */
    protected $configuration;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var StandaloneView
     */
    protected $view;

    /**
     * @var GraphicalFunctions
     */
    protected $graphicalFunctions;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var ButtonProviderInterface|null
     */
    protected $buttonProvider;

    /**
     * @var string
     */
    protected $webUploadsDir;

    /**
     * @var string
     */
    protected $absoluteUploadsDir;

    public function __construct(
        WidgetConfigurationInterface $configuration,
        GraphicalFunctions $graphicalFunctions,
        Cache $cache,
        StandaloneView $view,
        $buttonProvider = null,
        array $options = []
    ) {
        $this->configuration = $configuration;
        $this->graphicalFunctions = $graphicalFunctions;
        $this->cache = $cache;
        $this->view = $view;
        $this->buttonProvider = $buttonProvider;
        $this->options = \array_merge(
            [
                'limit' => 3,
                'lifeTime' => 43200,
                'imageWidth' => 100,
                'utmMedium' => '',
            ],
            $options
        );

        $this->webUploadsDir = '/' . static::UPLOADS_DIR;
        $this->absoluteUploadsDir = Environment::getPublicPath() . $this->webUploadsDir;
        if (!\is_dir($this->absoluteUploadsDir)) {
            GeneralUtility::mkdir_deep($this->absoluteUploadsDir);
        }
    }

    abstract public function renderWidgetContent(): string;

    abstract protected function getRssItems(): array;

    protected function changeUtmParameter(string $link): string
    {
        if ($this->options['utmMedium'] === '') {
            return $link;
        }

        return \sprintf(
            '%s?utm_medium=%s',
            \strtok($link, '?'),
            $this->options['utmMedium']
        );
    }

    protected function getImage($haystack): array
    {
        [$imageUrl, $imageAlt] = $this->getImageInformation($haystack);

        if (empty($imageUrl)) {
            return [];
        }

        if (\filter_var($imageUrl, \FILTER_VALIDATE_URL) === false) {
            return [];
        }

        $imageExtension = \pathinfo($imageUrl, \PATHINFO_EXTENSION);
        $scaledImageFileName = \md5($this->options['imageWidth'] . $imageUrl) . '.' . $imageExtension;
        $absoluteScaledImagePath = $this->absoluteUploadsDir . '/' . $scaledImageFileName;
        $webScaledImagePath = $this->webUploadsDir . '/' . $scaledImageFileName;

        if (!\file_exists($absoluteScaledImagePath)) {
            $originalDownloadedImagePath = $this->absoluteUploadsDir . '/' . \basename($imageUrl);

            if (false === \file_put_contents($originalDownloadedImagePath, GeneralUtility::getUrl($imageUrl))) {
                return [];
            }

            if ($imageExtension === 'svg') {
                \rename($originalDownloadedImagePath, $absoluteScaledImagePath);
            } else {
                $scaledImage = $this->graphicalFunctions->imageMagickConvert($originalDownloadedImagePath, '', $this->options['imageWidth']);
                \rename($scaledImage[3], $absoluteScaledImagePath);
                \unlink($originalDownloadedImagePath);
            }
        }

        return [
            'src' => $webScaledImagePath,
            'alt' => $imageAlt,
            'width' => $this->options['imageWidth'],
        ];
    }

    /**
     * @param mixed $haystack
     * @return array ['url' => '<url>', 'alt' => '<alt>']
     */
    abstract protected function getImageInformation($haystack): array;
}
