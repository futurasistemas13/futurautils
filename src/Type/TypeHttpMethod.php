<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Type;

use Futuralibs\Futurautils\Trait\EnumTrait;

enum TypeHttpMethod: String{

    use EnumTrait ;

    case POST = 'POST';
    case GET  = 'GET';
    case PUT  = 'PUT';
    case PATCH  = 'PATCH';
}