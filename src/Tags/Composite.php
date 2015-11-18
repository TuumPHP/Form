<?php
namespace Tuum\Form\Tags;

use Closure;

/**
 * @property null|Input|Select y
 * @property null|Input|Select m
 * @property null|Input|Select d
 * @property null|Input|Select H
 * @property null|Input|Select i
 * @property null|Input|Select s
 */
class Composite
{
    /**
     * @var Input[]|Select[]
     */
    private $fields = [];

    /**
     * @var Closure
     */
    private $format;

    /**
     * @var string|Closure
     */
    private $exploder = '[- :T]+';

    /**
     * @param string           $name
     * @param Input[]|Select[] $fields
     * @param string           $format
     * @param null             $exploder
     */
    public function __construct($name, $fields, $format, $exploder = null)
    {
        $this->fields = $fields;
        $this->format($format);
        $this->exploder = $exploder ?: $this->exploder;
        $this->name($name);
    }

    /**
     * @param $key
     * @return null|Input|Select
     */
    public function __get($key)
    {
        return array_key_exists($key, $this->fields) ? $this->fields[$key] : null;
    }

    /**
     * @param $name
     * @return $this
     */
    private function name($name)
    {
        foreach ($this->fields as $suffix => $tag) {
            $tag->name("{$name}_{$suffix}");
        }
        return $this;
    }

    /**
     * @param string|Closure $format
     * @return $this
     */
    public function format($format)
    {
        if (is_string($format)) {
            $format = function ($list) use ($format) {
                $fields = [
                    $format,
                ];
                foreach ($list as $tag) {
                    $fields[] = (string)$tag;
                }
                return call_user_func_array('sprintf', $fields);
            };
        }
        $this->format = $format;
        return $this;
    }

    /**
     * @param string $head
     * @return $this
     */
    public function head($head)
    {
        foreach ($this->fields as $tag) {
            if (method_exists($tag, 'head')) {
                $tag->head($head);
            }
        }
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function value($value)
    {
        if (is_null($value) || $value === '') {
            return $this;
        }
        $list = $this->explode($value);
        $idx  = 0;
        foreach ($this->fields as $key => $tag) {
            if (array_key_exists($key, $list)) {
                $tag->value($list[$key]);
            } elseif (array_key_exists($idx, $list)) {
                $tag->value($list[$idx]);
            }
            $idx++;
        }
        return $this;
    }

    /**
     * @param string $value
     * @return array
     */
    private function explode($value)
    {
        if ($this->exploder instanceof Closure) {
            $exploder = $this->exploder;
            return $exploder($value);
        }
        return preg_split("/{$this->exploder}/", $value);
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
        $formatter = $this->format;
        return $formatter($this->fields);
    }
}