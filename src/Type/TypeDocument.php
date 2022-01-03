<?php

namespace Futuralibs\Futurautils\Type;

use Futuralibs\Futurautils\Trait\EnumTrait;

enum TypeDocument: int {

    use EnumTrait ;

    case CPF = 1;
    case CNPJ = 2;

    public function document(): string
    {
        return match($this)
        {
            self::CPF => 'CPF',
            self::CNPJ => 'CNPJ',
        };
    }

    /**
     * @throws Exception
     */
    public static function find(string $document): int
    {
        return match($document)
        {
            self::CPF->document() => self::CPF->value,
            self::CNPJ->document() => self::CNPJ->value,
            default => throw new Exception('Unexpected match value'),
        };
    }
}