<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Type;


use Futuralibs\Futurautils\Interface\TypeInterface;
use Futuralibs\Futurautils\Trait\EnumTrait;

enum TypeStatus: int implements TypeInterface
{

    use EnumTrait;

    case Enabled = 1;
    case Disabled = 0;

    public function getName(): string
    {
        return match($this)
        {
            self::Enabled => 'enabled',
            self::Disabled => 'disabled',
        };
    }
}