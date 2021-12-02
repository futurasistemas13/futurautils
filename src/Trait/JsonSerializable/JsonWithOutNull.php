<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Trait\JsonSerializable;

trait JsonWithOutNull
{
    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $class = [];
        $reflection = new \ReflectionClass(get_class($this));

        foreach ($reflection->getParentClass()->getProperties() as $parent) {
            $parent->setAccessible(true);
            if ($parent->getValue($this) !== null) {
                $class[$parent->getName()] = $parent->getValue($this);
            }
        }

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            if ($property->getValue($this) !== null) {
                $class[$property->getName()] = $property->getValue($this);
            }
        }
        return $class;
    }
}