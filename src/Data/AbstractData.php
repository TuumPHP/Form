<?php
namespace Tuum\Form\Data;

use Traversable;

abstract class AbstractData implements \ArrayAccess, \IteratorAggregate
{
    /**
     * @var array|object
     */
    protected $data = [];

    /**
     * @var callable|Escape
     */
    protected $escape;

    /**
     * @ param Message $message
     *
     * @param array|object  $data
     * @param null|callable $escape
     */
    public function __construct($data = [], $escape = null)
    {
        $this->data   = $data;
        $this->escape = $escape ?: ['Tuum\Form\Data\Escape', 'htmlSafe'];
    }

    /**
     * @param array|object  $data
     * @param null|callable $escape
     * @return static
     */
    public static function forge($data = [], $escape = null)
    {
        return new static($data, $escape);
    }

    /**
     * accessing data as property. returns escaped value.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * get an escaped value.
     *
     * @param string     $key
     * @param null|mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $value  = $this->raw($key, $default);
        $escape = $this->escape;
        return $escape($value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return bool
     */
    public function exists($name, $value = null)
    {
        $found = $this->raw($name);
        if (is_null($found)) {
            return false;
        }
        if (!is_null($value)) {
            if (is_array($found)) {
                return in_array($value, $found);
            }
            return (string)$value === (string)$found;
        }
        return true;
    }

    /**
     * get a raw value.
     *
     * @param string     $key
     * @param null|mixed $default
     * @return mixed
     */
    public function raw($key, $default = null)
    {
        if (strpos($key, '[') === false) {
            return Accessor::get($this->data, $key, $default);
        }
        $found = $this->parseRaw($key);
        if (!is_null($found)) {
            return $found;
        }
        return $default;
    }

    /**
     * get a raw value for form element array name (with []).
     *
     * @param string $key
     * @return null|mixed
     */
    private function parseRaw($key)
    {
        $key = str_replace('[]', '', $key);
        parse_str($key, $levels);
        if (is_null($levels)) {
            return null;
        }
        $inputs = $this->data;
        return $this->recurseGet($levels, $inputs);
    }

    /**
     * gets a value from $input array.
     *
     * returns null if not found. or
     * returns an empty space if key is set but has not real value.
     *
     * @param array $levels
     * @param mixed $inputs
     * @return mixed
     */
    private function recurseGet($levels, $inputs)
    {
        if (!is_array($levels)) {
            if (is_null($inputs) || $inputs === false) {
                $inputs = '';
            }
            return $inputs;
        }
        list($key, $next) = each($levels);
        // an array
        if (Accessor::has($inputs, $key)) {
            return $this->recurseGet($next, Accessor::get($inputs, $key));
        }
        return null;
    }

    /**
     * returns new Data object populated with its data[$key].
     *
     * @param string $key
     * @return Data
     */
    public function extractKey($key)
    {
        $self       = clone($this);
        $self->data = Accessor::get($this->data, $key) ?: [];
        return $self;
    }

    /**
     * Retrieve an external iterator
     *
     * @return Traversable
     */
    public function getIterator()
    {
        $data = $this->data;
        foreach ($this->data as $key => $val) {
            $data[$key] = $this->extractKey($key);
        }
        return new \ArrayIterator($data);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * @param mixed
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->data[$offset]);
        }
    }

}
