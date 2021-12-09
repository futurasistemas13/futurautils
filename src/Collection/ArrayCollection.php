<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Collection;

use Futuralibs\Futurautils\Interface\ArrayAccess;

class ArrayCollection implements ArrayAccess
{

    private $data;

    // Não é necessário para ArrayAccess funcionar
    // adicionei para facilitar o uso com um array
    // já existente
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    // OBRIGATÓRIO para a interface ArrayAccess
    public function offsetExists($offset) :bool
    {
        return isset($this->data[$offset]);
    }

    // OBRIGATÓRIO para a interface ArrayAccess
    public function offsetGet($offset) : mixed
    {
        return $this->data[$offset] ?? null;
    }

    // OBRIGATÓRIO para a interface ArrayAccess
    public function offsetSet($offset, $value) :void
    {
        $this->data[$offset] = $value;
    }

    // OBRIGATÓRIO para a interface ArrayAccess
    public function offsetUnset($offset) :void
    {
        unset($this->data[$offset]);
    }

    // ordena o array em ordem alfabética
    public function order() :void
    {
        sort($this->data);
    }

    // método mágico, permite que uma classe
    // seja usada como string
    public function __toString() :string
    {
        return json_encode($this->data);
    }

}