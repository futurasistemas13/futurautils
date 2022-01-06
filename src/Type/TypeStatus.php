<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Type;


use Futuralibs\Futurautils\Trait\EnumTrait;

enum TypeStatus: int {

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