<?php

namespace Futuralibs\Futurautils\Type;

use Futuralibs\Futurautils\Trait\EnumTrait;

enum TypeDocument: String {

    use EnumTrait ;

    case CPF = 'CPF';
    case CNPJ = 'CNPJ';
}