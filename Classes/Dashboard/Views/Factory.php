<?php

declare(strict_types=1);

/*
 * This file is part of the "jobrouter_rss_widgets" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\JobRouterRssWidgets\Dashboard\Views;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * @internal
 */
final class Factory
{
    private function __construct()
    {
    }

    public static function widgetTemplate(): StandaloneView
    {
        /** @var StandaloneView $view */
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->getRenderingContext()->getTemplatePaths()->fillDefaultsByPackageName('jobrouter_rss_widgets');

        return $view;
    }
}
