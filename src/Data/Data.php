<?php
namespace Tuum\Form\Data;

class Data extends AbstractData
{
    // +----------------------------------------------------------------------+
    //  construction
    // +----------------------------------------------------------------------+
    /**
     * @param \Closure $closure
     */
    public function execute($closure)
    {
        return $closure($this->data);
    }

    /**
     * get value as hidden tag using $key as name.
     *
     * @param string $key
     * @return string
     */
    public function hiddenTag($key)
    {
        if ($this->offsetExists($key)) {
            $value = $this->get($key);
            return "<input type='hidden' name='{$key}' value='{$value}' />";
        }
        return '';
    }

    /**
     * get keys of current data (if it is an array).
     *
     * @return array
     */
    public function getKeys()
    {
        return is_array($this->data) ? array_keys($this->data) : [];
    }

}