<?php
namespace Tuum\Form;

use Tuum\Form\Tags\Input;

/**
 * Class Form
 *
 * @package Tuum\Form
 *          
 * @method Input text( string $name, string $value = null )
 */
class Form
{
    private $inputs = [
        'text',
    ];
    
    public function __call($type, $args)
    {
        /*
         * create Input objects.
         */
        if (in_array($type, $this->inputs)) {
            if (!array_key_exists(0, $args)) {
                throw new \InvalidArgumentException();
            }
            $name = $args[0];
            $value = array_key_exists(1, $args) ? $args[1] : null;
            return (new Input($type, $name))->value($value);
        }
        return '';
    }
    
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
    
}