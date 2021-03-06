<?php

namespace Futuralibs\Futurautils\Type;

use Futuralibs\Futurautils\Interface\TypeInterface;
use Futuralibs\Futurautils\Trait\EnumTrait;

enum TypeDocument: int implements TypeInterface
{

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