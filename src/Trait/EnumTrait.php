<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Trait;

use Exception;

trait EnumTrait
{

    public static function getArray(): array
    {
        $array = [];
        foreach (self::cases() as $enum) {
            $array[$enum->name] = $enum->value ;
        }
        return $array;
    }

    public static function getKeys(): array
    {
        return array_keys(self::getArray());
    }

    public static function getValues(): array
    {
        return array_values(self::getArray());
    }

    /**
     * @throws Exception
     */
    public static function find(string $match)
    {
        $find = array_filter(self::cases(), function($value) use ($match) {
            return $value->name == $match;
        });

        if ($find === null) {
            throw new Exception('Unexpected match value');
        }

        return current($find);
    }

    /**
     * @throws Exception
     */
    public static function findIndex(int $index)
    {
        $find = array_filter(self::cases(), function($value) use ($index) {
            return $value->value == $index;
        });

        if ($find === null) {
            throw new Exception('Unexpected match value');
        }

        return current($find);
    }

}