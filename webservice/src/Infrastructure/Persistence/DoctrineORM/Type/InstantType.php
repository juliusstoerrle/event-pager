<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\DoctrineORM\Type;

use Brick\DateTime\Instant;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use function preg_match;
use function str_pad;

final class InstantType extends Type
{
    public const NAME = 'instant';

    /**
     * @template T
     *
     * @param T $value
     *
     * @return (T is null ? null : string)
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof Instant) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', Instant::class]);
        }

        if ($value->getEpochSecond() >= 10_000_000_000 || $value->getEpochSecond() <= -10_000_000_000) {
            throw ConversionException::conversionFailedFormat($value->toDecimal(), self::NAME, '-10M to 10M seconds around Unix epoch.');
        }

        return $value->toDecimal();
    }

    /**
     * @template T
     *
     * @param T $value
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Instant
    {
        if (null === $value) {
            return null;
        }

        if (!is_numeric($value)) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', 'string', 'int', 'float']);
        }

        $matches = [];
        if (1 === preg_match('@\A(\d{1,10})(?:\.(\d{0,9}))?\z@', (string) $value, $matches)) {
            return Instant::of(
                (int) $matches[1],
                isset($matches[2]) ? (int) str_pad($matches[2], 9, '0') : 0
            );
        }

        throw ConversionException::conversionFailedFormat($value, $this->getName(), '/\d{1,10}(\.\d{0,9})?/');
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDecimalTypeDeclarationSQL([
            'precision' => 19,
            'scale' => 9,
        ]);
    }
}
