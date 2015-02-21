<?php
namespace Tuum\Form;

use Tuum\Form\Tags\Input;
use Tuum\Form\Tags\TextArea;

/**
 * Class Form
 *
 * @package Tuum\Form
 *          
 * @method Input text(string $name, string $value = null)
 * @method Input hidden(string $name, string $value = null )
 * @method Input search(string $name, string $value = null )
 * @method Input tel(string $name, string $value = null )
 * @method Input url(string $name, string $value = null )
 * @method Input email(string $name, string $value = null )
 * @method Input password(string $name, string $value = null )
 * @method Input datetime(string $name, string $value = null )
 * @method Input date(string $name, string $value = null )
 * @method Input month(string $name, string $value = null )
 * @method Input week(string $name, string $value = null )
 * @method Input time(string $name, string $value = null )
 * @method Input number(string $name, string $value = null )
 * @method Input range(string $name, string $value = null )
 * @method Input color(string $name, string $value = null )
 * @method Input file(string $name, string $value = null )
 * @method Input radio(string $name, string $value = null )
 * @method Input checkbox(string $name, string $value = null )
 */
class Form
{
    private $inputs = [
        'text',
        'hidden',
        'search',
        'tel',
        'url',
        'email',
        'password',
        'datetime',
        'date',
        'month',
        'week',
        'time',
        'number',
        'range',
        'color',
        'file',
        'radio',
        'checkbox',
    ];

    /**
     * @param string $type
     * @param array  $args
     * @return $this|string
     */
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
            return $this->input($type, $name, $value);
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

    /**
     * @param string      $name
     * @param string|null $value
     * @return TextArea
     */
    public function textArea($name, $value = null)
    {
        return (new TextArea($name))->contents($value);
    }

    /**
     * @return Tags\Form
     */
    public function open()
    {
        return new \Tuum\Form\Tags\Form();
    }

    /**
     * @return string
     */
    public function close()
    {
        return \Tuum\Form\Tags\Form::close();
    }
}