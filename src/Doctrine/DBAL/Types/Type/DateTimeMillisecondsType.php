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

namespace OskarStark\Doctrine\Type\Doctrine\DBAL\Types\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Types\Exception\InvalidFormat;
use Doctrine\DBAL\Types\Exception\InvalidType;
use OskarStark\Doctrine\Postgres\Platform\Doctrine\DBAL\Platforms\PostgreSQLMillisecondsPlatform;

final class DateTimeMillisecondsType extends DateTimeType
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        if ($platform instanceof PostgreSQLMillisecondsPlatform) {
            return 'TIMESTAMP(3) WITHOUT TIME ZONE';
        }

        return parent::getSQLDeclaration($column, $platform);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s.v');
        }

        throw InvalidType::new($value, \Doctrine\DBAL\Types\Type::getTypeRegistry()->lookupName($this), ['null', \DateTimeInterface::class]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?\DateTime
    {
        if (null === $value || $value instanceof \DateTime) {
            return $value;
        }

        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s.v', $value);

        if (false === $dateTime) {
            $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s.u', $value);
        }

        if (false === $dateTime) {
            $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
        }

        if (false === $dateTime) {
            throw InvalidFormat::new($value, \Doctrine\DBAL\Types\Type::getTypeRegistry()->lookupName($this), 'Y-m-d H:i:s.v');
        }

        return $dateTime;
    }
}
