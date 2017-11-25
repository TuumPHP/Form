<?php
namespace Tuum\Form\Tags;

/**
 * Class Tags
 *
 * @package Tuum\Form
 *
 * @method $this class($class_name)
 */
class Tag
{
    /**
     * @var string
     */
    private $tagName;

    /**
     * @var Attribute
     */
    private $attributes;

    /**
     * @var bool
     */
    private $closed = false;

    /**
     * @var string
     */
    private $contents = null;

    // +----------------------------------------------------------------------+
    //  construction 
    // +----------------------------------------------------------------------+
    /**
     * @param string $tagName
     */
    public function __construct($tagName)
    {
        $this->tagName = strtolower($tagName);
        $this->attributes = new Attribute();
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
        return TagToString::format($this);
    }

    /**
     * @return $this
     */
    public function closeTag()
    {
        $this->closed = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function isClosed()
    {
        return $this->closed;
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
        $this->attributes->$method(...$args);
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function contents($value)
    {
        $this->contents = $value;
        return $this;
    }

    /**
     * @param string $key
     * @param string $style
     * @return $this
     */
    public function style($key, $style = null)
    {
        $this->attributes->style($key, $style);
        return $this;
    }

    /**
     * @param string      $key
     * @param mixed       $value
     * @param bool|string $sep
     * @return $this
     */
    public function setAttribute($key, $value = true, $sep = false)
    {
        $this->attributes->setAttribute($key, $value, $sep);
        return $this;
    }

    /**
     * @param array $data
     */
    public function fillAttributes(array $data)
    {
        $this->attributes->fillAttributes($data);
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
        return $this->attributes->get($key);
    }

    /**
     * @return string
     */
    public function getTagName()
    {
        return $this->tagName;
    }

    /**
     * @return Attribute
     */
    public function getAttribute()
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @return bool
     */
    public function hasContents()
    {
        return !is_null($this->contents);
    }
    // +----------------------------------------------------------------------+
}