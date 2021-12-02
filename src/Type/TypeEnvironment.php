<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Type;

use Futuralibs\Futurautils\Trait\EnumTrait;

enum TypeEnvironment: String{

    use EnumTrait ;

    case SandBox = 'SandBox';
    case Production = 'Production';
}