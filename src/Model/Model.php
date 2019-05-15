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

    /**
     * Converts the model to a json string
     * @return false|string
     */
    public function __toString()
    {
        return json_encode($this->asArray());
    }

    /**
     * Convert the model to an array
     * @return array
     */
    public function asArray()
    {
        $data = $this->_data;

        array_walk($data, function (&$value, $key) {
            if (is_array($value)) {
                $value = array_map(function ($sub) {
                    if ($sub instanceof Model) return $sub->asArray();
                    return $sub;
                }, $value);
            } elseif ($value instanceof Model) {
                $value = $value->asArray();
            } elseif ($value instanceof DateTime) {
                $value = $value->format($this->getDateFormat($key));
            }
        });

        return $data;
    }

    protected function getDateFormat(string $field): string
    {
        return DateTime::ISO8601;
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