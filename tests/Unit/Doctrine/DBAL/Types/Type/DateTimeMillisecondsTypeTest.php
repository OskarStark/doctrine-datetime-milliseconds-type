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

use Doctrine\DBAL\Types\Type;
use OskarStark\Doctrine\Postgres\Platform\Doctrine\DBAL\Platforms\PostgreSQLMillisecondsPlatform;
use OskarStark\Doctrine\Testcase\TypeTestCase;
use OskarStark\Doctrine\Type\Doctrine\DBAL\Types\Type\DateTimeMillisecondsType;

final class DateTimeMillisecondsTypeTest extends TypeTestCase
{
    private static DateTimeMillisecondsType $type;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$type = new DateTimeMillisecondsType();

        if (Type::getTypeRegistry()->has('datetime')) {
            Type::getTypeRegistry()->override('datetime', self::$type);
        } else {
            Type::getTypeRegistry()->register('datetime', self::$type);
        }
    }

    /**
     * @test
     */
    public function getSQLDeclaration(): void
    {
        self::assertSame(
            'TIMESTAMP(3) WITHOUT TIME ZONE',
            self::$type->getSQLDeclaration([], new PostgreSQLMillisecondsPlatform()),
        );
    }

    /**
     * @return DateTimeMillisecondsType
     */
    protected static function createType(): Type
    {
        return self::$type;
    }

    protected static function provideName(): string
    {
        return 'datetime';
    }
}
