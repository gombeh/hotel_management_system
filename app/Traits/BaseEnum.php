<?php

namespace App\Traits;

use App\Attributes\Display;
use Illuminate\Support\Str;
use ReflectionClassConstant;

trait BaseEnum
{
    private static function getDisplay(self $enum): array
    {
        $ref = new ReflectionClassConstant(static::class, $enum->name);
        $classAttributes = $ref->getAttributes(Display::class);

        if (count($classAttributes) === 0) {
            return [
                'label' => Str::headline($enum->value),
                'bgClass' => null,
                'isDefault' => false,
            ];
        }

        return (array)$classAttributes[0]->newInstance();
    }

    public static function asSelect(): array
    {
        /** @var array<string,string> $values */
        $values = collect(static::cases())
            ->map(function ($enum) {
                return [
                    ...static::getDisplay($enum),
                    'value' => $enum->value,
                ];
            })->toArray();

        return $values;
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, static::cases());
    }

    public static function asString(): string
    {
        return join(',', static::values());
    }

    public static function default(): object
    {
        $defaultValue = collect(static::cases())
            ->filter(function ($enum) {
                ['isDefault' => $isDefault] = static::getDisplay($enum);
                return $isDefault;
            });

        return $defaultValue->first() ?? self::cases()[0];
    }
}
