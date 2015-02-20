<?php
namespace Tuum\Form\Tags;

use Closure;

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
     * @var
     */
    private $separator = '[- :T]+';

    /**
     * @param string           $name
     * @param Input[]|Select[] $fields
     * @param string           $format
     */
    public function __construct($name, $fields, $format)
    {
        $this->fields = $fields;
        if (is_string($format)) {
            $format = function($list) use($format) {
                $fields = [
                    $format,
                ];
                foreach($list as $tag) {
                    $fields[] = (string) $tag;
                }
                return call_user_func_array('sprintf', $fields);
            };
        }
        $this->format = $format;
        $this->name($name);
    }

    /**
     * @param $name
     * @return $this
     */
    private function name($name)
    {
        foreach($this->fields as $suffix => $tag) {
            $tag->name("{$name}_{$suffix}");
        }
        return $this;
    }

    /**
     * @param string $head
     * @return $this
     */
    public function head($head)
    {
        foreach($this->fields as $tag) {
            $tag->head($head);
        }
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function value($value)
    {
        if(is_null($value) || $value === '') {
            return $this;
        }
        $list = $this->explode($value);
        $idx  = 0;
        foreach($this->fields as $key => $tag) {
            if(array_key_exists($key, $list)) {
                $tag->value($list[$key]);
            } 
            elseif(array_key_exists($idx, $list)) {
                $tag->value($list[$idx]);
            }
            $idx ++;
        }
        return $this;
    }

    /**
     * @param string $value
     * @return array
     */
    private function explode($value)
    {
        return preg_split( "/{$this->separator}/", $value);
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