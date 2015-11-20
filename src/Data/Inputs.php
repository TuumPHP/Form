<?php
namespace Tuum\Form\Data;

class Inputs extends AbstractData
{
    /**
     * @param string $name
     * @param string $value
     * @return string
     */
    public function checked($name, $value)
    {
        if ($this->exists($name, $value)) {
            return ' checked';
        }
        return '';
    }

    /**
     * @param string $name
     * @param string $value
     * @return string
     */
    public function selected($name, $value)
    {
        if ($this->exists($name, $value)) {
            return ' selected';
        }
        return '';
    }
}