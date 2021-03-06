<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Trait\JsonSerializable;

use Serializable;
use Futuralibs\Futurautils\Type\TypeAttributeIgnore;

trait JsonWithOutNull
{
    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->serializeRecursive($this);
    }

    private function serializeRecursive($obj): array
    {
        $IGNORE = 'ignore';
        $return = array();
        $reflection = new \ReflectionClass(get_class($obj));

        $attributes = $reflection->getProperties();
        while ($reflection->getParentClass()) {
            $reflection = $reflection->getParentClass();
            $attributes = array_merge_recursive($attributes, $reflection->getProperties());
        }

        foreach ($attributes as $prop) {
            $attributeList = $prop->getAttributes();

            $skipField = false;
            if (count($attributeList) > 0) {
                foreach ($attributeList as $attr) {
                    $ignoreField = false;
                    if (array_key_exists($IGNORE, $attr->getArguments())) {
                        foreach ($attr->getArguments()[$IGNORE] as $arg) {
                            if (($arg == TypeAttributeIgnore::IgnoreNull) && (is_null($prop->getValue($obj)))) {
                                $ignoreField = true;
                                continue;
                            }

                            if (($arg == TypeAttributeIgnore::IgnoreEmpty) && (($prop->getValue($obj) === ''))) {
                                $ignoreField = true;
                                continue;
                            }
                        }
                    }

                    if (($ignoreField) || ((!$attr->getName() == Serializable::class))) {
                        $skipField = true;
                        continue;
                    }
                }
            } else {
                $skipField = true;
                continue;
            }
            if ($skipField) {
                continue;
            }

            $prop->setAccessible(true);
            if (is_array($prop->getValue($obj))) {
                if (count($prop->getValue($obj)) > 0) {
                    foreach ($prop->getValue($obj) as $item) {
                        if (is_object($item)) {
                            $return[$prop->getName()][] = $this->serializeRecursive($item);
                        } else {
                            $return[$prop->getName()] = $prop->getValue($obj);
                        }
                    }
                } else {
                    $return[$prop->getName()] = array();
                }

            } elseif (is_object($prop->getValue($obj))) {
                $return[$prop->getName()] = $this->serializeRecursive($prop->getValue($obj));
            } else {
                $return[$prop->getName()] = $prop->getValue($obj);
            }
        }
        return $return;
    }
}