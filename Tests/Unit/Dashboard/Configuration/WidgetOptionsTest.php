<?php

declare(strict_types=1);

/*
 * This file is part of the "jobrouter_rss_widgets" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\JobRouterRssWidgets\Tests\Dashboard\Configuration;

use Brotkrueml\JobRouterRssWidgets\Dashboard\Configuration\WidgetOptions;
use PHPUnit\Framework\TestCase;

final class WidgetOptionsTest extends TestCase
{
    /**
     * @test
     */
    public function optionsAreReturnedCorrectlyWhenSetAndGettingThem(): void
    {
        $options = new WidgetOptions([
            'feedUrl' => 'http://example.org/rss',
            'limit' => 42,
            'lifeTime' => 12345,
            'imageWidth' => 333,
        ]);

        self::assertSame('http://example.org/rss', $options->getFeedUrl());
        self::assertSame(42, $options->getLimit());
        self::assertSame(12345, $options->getLifeTime());
        self::assertSame(333, $options->getImageWidth());
    }

    /**
     * @test
     */
    public function defaultOptionsAreReturnedCorrectlyWhenNotSet(): void
    {
        $options = new WidgetOptions([
            'feedUrl' => 'http://example.org/rss',
        ]);

        self::assertSame(5, $options->getLimit());
        self::assertSame(43200, $options->getLifeTime());
        self::assertSame(100, $options->getImageWidth());
    }

    /**
     * @test
     */
    public function feedUrlMustBeAvailableOnInitialisation(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1590918307);
        $this->expectExceptionMessage('The option "feedUrl" was not defined or is not a valid URL, "" given');

        new WidgetOptions([]);
    }

    /**
     * @test
     */
    public function feedUrlMustBeAValidURL(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1590918307);
        $this->expectExceptionMessage('The option "feedUrl" was not defined or is not a valid URL, "not valid url" given');

        new WidgetOptions([
            'feedUrl' => 'not valid url',
        ]);
    }

    /**
     * @test
     * @dataProvider dataProviderForNumericOptionsThrowExceptionIfPositiveInteger
     */
    public function numericOptionsThrowExceptionIfPositiveInteger(array $options): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1590917577);

        new WidgetOptions($options);
    }

    public function dataProviderForNumericOptionsThrowExceptionIfPositiveInteger(): \Generator
    {
        yield 'limit is negative' => [
            [
                'feedUrl' => 'http://example.org/rss',
                'limit' => -1,
            ],
        ];

        yield 'limit is 0' => [
            [
                'feedUrl' => 'http://example.org/rss',
                'limit' => 0,
            ],
        ];

        yield 'lifeTime is negative' => [
            [
                'feedUrl' => 'http://example.org/rss',
                'lifeTime' => -1,
            ],
        ];

        yield 'lifeTime is 0' => [
            [
                'feedUrl' => 'http://example.org/rss',
                'lifeTime' => 0,
            ],
        ];

        yield 'imageWidth is negative' => [
            [
                'feedUrl' => 'http://example.org/rss',
                'lifeTime' => -1,
            ],
        ];

        yield 'imageWidth is 0' => [
            [
                'feedUrl' => 'http://example.org/rss',
                'lifeTime' => 0,
            ],
        ];
    }
}
