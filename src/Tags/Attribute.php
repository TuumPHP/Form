<?php
namespace Tuum\Form\Tags;

/**
 * Class Tags
 *
 * @package Tuum\Form
 *
 * @method $this class($class_name)
 */
class Attribute implements \ArrayAccess
{
    /**
     * @var array
     */
    private $attributes = array();

    // +----------------------------------------------------------------------+
    //  construction 
    // +----------------------------------------------------------------------+
    /**
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return TagToString::htmlProperty($this);
    }

    // +----------------------------------------------------------------------+
    //  setting up
    // +----------------------------------------------------------------------+
    /**
     * @param string $method
     * @param array  $args
     * @return $this
     */
    public function __call($method, $args)
    {
        if ($method === 'class') {
            $method = 'class_';
        }
        if (method_exists($this, $method)) {
            return $this->$method($args[0]);
        }
        $args = array_merge([$method], $args);
        return call_user_func_array([$this, 'setAttribute'], $args);
    }
    
    /**
     * @param string $class
     * @return $this
     */
    public function class_($class)
    {
        return $this->setAttribute('class', $class, ' ');
    }

    /**
     * @param string $key
     * @param string $style
     * @return $this
     */
    public function style($key, $style = null)
    {
        $style = $style ? "{$key}:$style" : $key;
        return $this->setAttribute('style', $style, '; ');
    }

    /**
     * @param string      $key
     * @param mixed       $value
     * @param bool|string $sep
     * @return $this
     */
    public function setAttribute($key, $value = true, $sep = false)
    {
        if (!isset($this->attributes[$key])) {
            $this->attributes[$key] = $value;
        } elseif ($sep === false) {
            $this->attributes[$key] = $value;
        } else {
            $sep = (string)$sep;
            $this->attributes[$key] .= $sep . $value;
        }
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function fillAttributes(array $data)
    {
        $this->attributes = array_merge($this->attributes, $data);
        return $this;
    }

    // +----------------------------------------------------------------------+
    //  getting information
    // +----------------------------------------------------------------------+
    /**
     * @param string $key
     * @return null|string
     */
    public function get($key)
    {
        return array_key_exists($key, $this->attributes) ? $this->attributes[$key] : null;
    }
    
    /**
     * @return array
     */
    public function getAttribute()
    {
        return $this->attributes;
    }

    /**
     * Whether a offset exists
     *
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    /**
     * Offset to retrieve
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return array_key_exists($offset, $this->attributes) ? $this->attributes[$offset] : null;
    }

    /**
     * Offset to set
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * Offset to unset
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }
}