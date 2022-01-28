<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Type;

use Futuralibs\Futurautils\Trait\EnumTrait;

enum TypeAttributeIgnore{
    case IgnoreNull;
    case IgnoreEmpty;
}