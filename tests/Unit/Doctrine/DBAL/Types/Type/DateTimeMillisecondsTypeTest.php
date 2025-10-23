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
     * @test
     */
    public function convertToDatabaseValueWithNull(): void
    {
        $platform = new PostgreSQLMillisecondsPlatform();

        self::assertNull(self::$type->convertToDatabaseValue(null, $platform));
    }

    /**
     * @test
     */
    public function convertToDatabaseValueWithDateTime(): void
    {
        $platform = new PostgreSQLMillisecondsPlatform();
        $dateTime = new \DateTime('2025-10-23 14:30:45.123');

        $result = self::$type->convertToDatabaseValue($dateTime, $platform);

        self::assertSame('2025-10-23 14:30:45.123', $result);
    }

    /**
     * @test
     */
    public function convertToDatabaseValueWithDateTimeImmutable(): void
    {
        $platform = new PostgreSQLMillisecondsPlatform();
        $dateTime = new \DateTimeImmutable('2025-10-23 14:30:45.456');

        $result = self::$type->convertToDatabaseValue($dateTime, $platform);

        self::assertSame('2025-10-23 14:30:45.456', $result);
    }

    /**
     * @test
     */
    public function convertToDatabaseValueThrowsExceptionForInvalidType(): void
    {
        $platform = new PostgreSQLMillisecondsPlatform();

        $this->expectException(\Doctrine\DBAL\Types\Exception\InvalidType::class);
        $this->expectExceptionMessage('Could not convert PHP value');

        self::$type->convertToDatabaseValue('invalid', $platform);
    }

    /**
     * @test
     */
    public function convertToPHPValueWithNull(): void
    {
        $platform = new PostgreSQLMillisecondsPlatform();

        self::assertNull(self::$type->convertToPHPValue(null, $platform));
    }

    /**
     * @test
     */
    public function convertToPHPValueWithDateTime(): void
    {
        $platform = new PostgreSQLMillisecondsPlatform();
        $dateTime = new \DateTime('2025-10-23 14:30:45.123');

        $result = self::$type->convertToPHPValue($dateTime, $platform);

        self::assertSame($dateTime, $result);
    }

    /**
     * @test
     */
    public function convertToPHPValueWithMillisecondsString(): void
    {
        $platform = new PostgreSQLMillisecondsPlatform();

        $result = self::$type->convertToPHPValue('2025-10-23 14:30:45.123', $platform);

        self::assertInstanceOf(\DateTime::class, $result);
        self::assertSame('2025-10-23 14:30:45.123000', $result->format('Y-m-d H:i:s.u'));
    }

    /**
     * @test
     */
    public function convertToPHPValueWithMicrosecondsString(): void
    {
        $platform = new PostgreSQLMillisecondsPlatform();

        $result = self::$type->convertToPHPValue('2025-10-23 14:30:45.123456', $platform);

        self::assertInstanceOf(\DateTime::class, $result);
        self::assertSame('2025-10-23 14:30:45.123456', $result->format('Y-m-d H:i:s.u'));
    }

    /**
     * @test
     */
    public function convertToPHPValueWithSecondsOnlyString(): void
    {
        $platform = new PostgreSQLMillisecondsPlatform();

        $result = self::$type->convertToPHPValue('2025-10-23 14:30:45', $platform);

        self::assertInstanceOf(\DateTime::class, $result);
        self::assertSame('2025-10-23 14:30:45.000000', $result->format('Y-m-d H:i:s.u'));
    }

    /**
     * @test
     */
    public function convertToPHPValueThrowsExceptionForInvalidFormat(): void
    {
        $platform = new PostgreSQLMillisecondsPlatform();

        $this->expectException(\Doctrine\DBAL\Types\Exception\InvalidFormat::class);
        $this->expectExceptionMessage('Could not convert database value');

        self::$type->convertToPHPValue('invalid-date', $platform);
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
