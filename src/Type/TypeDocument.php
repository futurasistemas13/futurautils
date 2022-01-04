<?php

namespace Futuralibs\Futurautils\Type;

use Futuralibs\Futurautils\Trait\EnumTrait;

enum TypeDocument: int {

    use EnumTrait ;

    case CPF = 1;
    case CNPJ = 2;

    public function getName(): string
    {
        return match($this)
        {
            self::CPF => 'CPF',
            self::CNPJ => 'CNPJ',
        };
    }

}