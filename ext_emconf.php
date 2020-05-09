<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'JobRouter RSS Widgets',
    'description' => 'Dashboard widgets displaying RSS feeds from JobRouter website',
    'category' => 'be',
    'state' => 'beta',
    'clearCacheOnLoad' => true,
    'author' => 'Chris Müller',
    'author_email' => 'typo3@krue.ml',
    'version' => '0.1.0-dev',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99',
            'dashboard' => '10.4.0-10.4.99',
        ],
    ],
    'autoload' => [
        'psr-4' => ['Brotkrueml\\JobRouterRssWidgets\\' => 'Classes']
    ],
];
