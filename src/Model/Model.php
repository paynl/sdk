<?php


namespace Paynl\SDK\Model;

use DateTime;

/**
 * Class Model
 * @package Paynl\SDK\Model
 */
class Model
{
    /**
     * @var array The data for this model
     */
    protected $_data;

    public function __construct()
    {
        $this->_data = [];
    }

    /**
     * Create an instance from an array
     *
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data)
    {
        $instance = new static();

        foreach ($data as $name => $value) {
            $instance->__set($name, $value);
        }
        return $instance;
    }

    public function asJson()
    {
        return json_encode($this->asArray());
    }

    /**
     * Converts the model to a json string
     * @return false|string
     */
    public function __toString()
    {
        return $this->asJson();
    }

    /**
     * Convert the model to an array
     * @return array
     */
    public function asArray()
    {
        return array_map(function ($value) {
            if (is_array($value)) {
                return array_map(function ($sub) {
                    if ($sub instanceof Model) return $sub->asArray();
                    return $sub;
                }, $value);
            } elseif ($value instanceof Model) {
                return $value->asArray();
            } elseif ($value instanceof DateTime) {
                return $value->format(DateTime::ISO8601);
            }
            return $value;
        }, $this->_data);
    }

    public function __get($name)
    {
        return $this->_data[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $value = is_array($value) ? (object)$value : $value;
        $this->_data[$name] = $value;
    }
}