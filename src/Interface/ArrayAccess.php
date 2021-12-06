<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Collection;

interface ArrayAccess
{
    // verificar se o item existe no array
    public function offsetExists(mixed $offset): boolean;

    // ler um item do array
    public function offsetGet(mixed $offset): mixed;

    // adicionar um item no array
    public function offsetSet(mixed $offset, mixed $value): void;

    // remover um item do array
    public function offsetUnset(mixed $offset): void;
}