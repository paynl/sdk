<?php

namespace Paynl\Api\Payment\Model;

abstract class Model
{
    /**
     * @return array
     */
    public function toArray()
    {
        $result = array();

        foreach ((array) $this as $index => $subItem) {
            if ($subItem === null) {
                continue;
            }
            $key = trim(str_replace(get_class($this), '', $index));
            $result[$key] = $subItem instanceof Model
                ? $subItem->toArray()
                : $subItem;
        }

        return $result;
    }
}