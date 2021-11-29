<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Trait;

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

}