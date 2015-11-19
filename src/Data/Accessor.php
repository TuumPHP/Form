<?php
namespace Tuum\Form\Data;

use ArrayAccess;

class Accessor
{
    /**
     * get value from an array or an object.
     *
     * @param array|object $data
     * @param string       $key
     * @param mixed        $default
     * @return mixed
     */
    public static function get($data, $key, $default = null)
    {
        if ((is_array($data) || $data instanceof ArrayAccess)) {
            return self::getArray($data, $key, $default);
        }
        if (is_object($data)) {
            return self::getObj($data, $key, $default);
        }

        return $default;
    }

    /**
     * @param array|ArrayAccess $data
     * @param string            $key
     * @param null              $default
     * @return mixed
     */
    public static function getArray($data, $key, $default = null)
    {
        return array_key_exists($key, $data) ? $data[$key]: $default;
    }

    /**
     * @param object $data
     * @param string $key
     * @param null   $default
     * @return mixed
     */
    public static function getObj($data, $key, $default = null)
    {
        $method = 'get' . $key;
        if (method_exists($data, $method)) {
            return $data->$method();
        }
        $method = 'get' . str_replace('_', '', $key);
        if (method_exists($data, $method)) {
            return $data->$method();
        }
        if (isset($data->$key)) {
            return $data->$key;
        }

        return $default;
    }

    /**
     * check if $data has a $key.
     * $data can be an array or an object.
     *
     * @param array|object $data
     * @param string       $key
     * @return bool
     */
    public static function has($data, $key)
    {
        if ((is_array($data) || $data instanceof ArrayAccess)) {
            return array_key_exists($key, $data);
        }
        if (!is_object($data)) {
            return false;
        }
        if (method_exists($data, 'get' . $key)) {
            return true;
        }
        if (method_exists($data, 'get' . str_replace('_', '', $key))) {
            return true;
        }
        if (isset($data->$key)) {
            return true;
        }

        return false;
    }
}