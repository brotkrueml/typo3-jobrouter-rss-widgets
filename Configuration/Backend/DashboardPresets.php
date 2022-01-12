<?php

declare(strict_types=1);

/*
 * This file is part of the "jobrouter_rss_widgets" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

return [
    'jobrouter_rss_widgets_de' => [
        'title' => 'LLL:EXT:jobrouter_rss_widgets/Resources/Private/Language/Dashboard.xlf:preset.de.title',
        'description' => 'LLL:EXT:jobrouter_rss_widgets/Resources/Private/Language/Dashboard.xlf:preset.de.description',
        'iconIdentifier' => 'content-dashboard',
        'defaultWidgets' => [
            'jobrouter_rss_widgets_blog_de',
            'jobrouter_rss_widgets_downloads_de',
            'jobrouter_rss_widgets_press_de',
            'jobrouter_rss_widgets_videos_de',
        ],
        'showInWizard' => true,
    ],
    'jobrouter_rss_widgets_en' => [
        'title' => 'LLL:EXT:jobrouter_rss_widgets/Resources/Private/Language/Dashboard.xlf:preset.en.title',
        'description' => 'LLL:EXT:jobrouter_rss_widgets/Resources/Private/Language/Dashboard.xlf:preset.en.description',
        'iconIdentifier' => 'content-dashboard',
        'defaultWidgets' => [
            'jobrouter_rss_widgets_blog_en',
            'jobrouter_rss_widgets_downloads_en',
            'jobrouter_rss_widgets_press_en',
            'jobrouter_rss_widgets_videos_en',
        ],
        'showInWizard' => true,
    ],
];
