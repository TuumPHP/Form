<?php
namespace Tuum\Form;

use Tuum\Form\Tags\Composite;
use Tuum\Form\Tags\Input;
use Tuum\Form\Tags\Select;

class Form
{
    /**
     * constructs Input form element object with any type. 
     * 
     * @param string      $type
     * @param string      $name
     * @param string|null $value
     * @return Input
     */
    public function input($type, $name, $value=null)
    {
        return (new Input($type, $name))->value($value);

    }
    /**
     * @param string      $name
     * @param string|null $value
     * @return Input
     */
    public function text($name, $value=null)
    {
        return (new Input('text', $name))->value($value);
    }
}