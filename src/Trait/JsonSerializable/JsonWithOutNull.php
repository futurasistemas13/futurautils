<?php
declare(strict_types=1);

namespace Futuralibs\Futurautils\Trait\JsonSerializable;

use Serializable;

trait JsonWithOutNull
{
    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $return     = array();
        $reflection = new \ReflectionClass(get_class($this));

        $attributes = $reflection->getProperties();
        while($reflection->getParentClass()){
            $reflection = $reflection->getParentClass();
            $attributes = array_merge_recursive($attributes, $reflection->getProperties());
        }

        foreach($attributes  as $prop){
            $attributeList = $prop->getAttributes();
            if(count($attributeList) > 0){
                foreach($attributeList as $attr){
                    if(!($attr->getName() == Serializable::class)){
                        continue;
                    }
                }
            }else{
                continue;
            }

            $prop->setAccessible(true);
            if(is_array($prop->getValue($this))){
                if(count($prop->getValue($this)) > 0){
                    foreach($prop->getValue($this) as $item){
                        if(is_object($item)){
                            $return[$prop->getName()][]  =  $this->convert($item);  
                        }else{
                            $return[$prop->getName()] =  $prop->getValue($this);  
                        }
                    }
                }else{
                    $return[$prop->getName()] = array();
                }

            }elseif(is_object($prop->getValue($this))){
                $return[$prop->getName()] = $this->convert($prop->getValue($this));
            }else{
                $return[$prop->getName()] =  $prop->getValue($this);
            }
        }
        return $return;
    }
}