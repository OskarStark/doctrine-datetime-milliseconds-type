<?php

declare(strict_types=1);

/*
 * This file is part of oskarstark/trimmed-non-empty-string.
 *
 * (c) Oskar Stark <oskarstark@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OskarStark\Doctrine\Type\Tests\Unit\Doctrine\DBAL\Types\Type;

use OskarStark\Doctrine\Testcase\TypeTestCase;
use OskarStark\Doctrine\Type\Doctrine\DBAL\Types\Type\DateTimeMillisecondsType;
use Doctrine\DBAL\Platforms\PostgreSQL100Platform;
use Doctrine\DBAL\Types\Type;

final class DateTimeMillisecondsTypeTest extends TypeTestCase
{
    /**
     * @test
     */
    public function getSQLDeclaration(): void
    {
        $type = new DateTimeMillisecondsType();

        self::assertSame(
            'TIMESTAMP(3) WITHOUT TIME ZONE',
            $type->getSQLDeclaration([], new PostgreSQL100Platform()),
        );
    }

    /**
     * @return DateTimeMillisecondsType
     */
    protected static function createType(): Type
    {
        return new DateTimeMillisecondsType();
    }

    protected static function name(): string
    {
        return 'datetime';
    }
}
