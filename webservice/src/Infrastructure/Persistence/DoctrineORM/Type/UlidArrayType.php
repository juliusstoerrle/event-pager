<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\DoctrineORM\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Symfony\Bridge\Doctrine\Types\UlidType;
use function count;
use function is_array;
use function is_resource;
use function is_string;

final class UlidArrayType extends Type
{
    public const NAME = 'ulid_array';

    private static function ulidType(): UlidType
    {
        return new UlidType();
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (!is_array($value) || 0 === count($value)) {
            return null;
        }

        $ulidType = self::ulidType();

        return implode(',', array_map(fn ($v) => $ulidType->convertToDatabaseValue($v, $platform), $value));
    }

    /**
     * @return list<\Symfony\Component\Uid\Ulid>
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): array
    {
        if (null === $value) {
            return [];
        }

        $value = is_resource($value) ? stream_get_contents($value) : $value;

        $ulidType = self::ulidType();

        if (false === is_string($value)) {
            throw ConversionException::conversionFailed($value, 'Ulid[]');
        }

        /* @phpstan-ignore return.type */
        return array_map(fn ($v) => $ulidType->convertToPHPValue($v, $platform), explode(',', $value));
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getClobTypeDeclarationSQL($column);
    }
}
