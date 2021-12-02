<?php

declare(strict_types=1);

namespace Futuralibs\Futurautils\Component;

abstract class AbstractComponent implements \JsonSerializable
{
    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $class = [];
        $reflection = new \ReflectionClass(get_class($this));

        while ($parent = $reflection->getParentClass()) {
            foreach ($parent->getProperties() as $property) {
                $property->setAccessible(true);
                $class[$property->getName()] = $property->getValue($this);
            }
        }

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $class[$property->getName()] = $property->getValue($this);
        }
        return $class;
    }
}