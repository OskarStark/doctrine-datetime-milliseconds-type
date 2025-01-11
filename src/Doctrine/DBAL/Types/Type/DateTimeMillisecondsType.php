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
use Doctrine\DBAL\Platforms\PostgreSQL100Platform;
use Doctrine\DBAL\Types\DateTimeType;

final class DateTimeMillisecondsType extends DateTimeType
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        if ($platform instanceof PostgreSQL100Platform) {
            return 'TIMESTAMP(3) WITHOUT TIME ZONE';
        }

        return parent::getSQLDeclaration($column, $platform);
    }
}
