<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'JobRouter RSS Widgets',
    'description' => 'Dashboard widgets displaying RSS feeds from the JobRouter website (www.jobrouter.com)',
    'category' => 'be',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'author' => 'Chris Müller',
    'author_email' => 'typo3@krue.ml',
    'version' => '1.0.0',
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
