<?php
namespace Tuum\Form;

use Tuum\Form\Lists\ListInterface;
use Tuum\Form\Tags\Input;
use Tuum\Form\Tags\InputList;
use Tuum\Form\Tags\Select;
use Tuum\Form\Tags\Tag;
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
class Forms
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
     * @param string      $label
     * @param null|string $for
     * @return Tag
     */
    public function label($label, $for=null)
    {
        return (new Tag('label'))->contents($label)->setAttribute('for', $for);
    }

    /**
     * @param null $value
     * @return Input
     */
    public function submit($value=null)
    {
        return (new Input('submit', null))->value($value);
    }

    /**
     * @param null $value
     * @return Input
     */
    public function reset($value=null)
    {
        return (new Input('reset', null))->value($value);
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
     * @param string $name
     * @param array|ListInterface  $list
     * @param null|string $value
     * @return Select
     */
    public function select($name, $list, $value=null)
    {
        return new Select($name, $list, $value);
    }
    
    /**
     * @param string $name
     * @param array|ListInterface  $list
     * @param null|string $value
     * @return InputList
     */
    public function checkList($name, $list, $value=null)
    {
        return new InputList('checkbox', $name, $list, $value);
    }

    /**
     * @param string $name
     * @param array|ListInterface  $list
     * @param null|string $value
     * @return InputList
     */
    public function radioList($name, $list, $value=null)
    {
        return new InputList('radio', $name, $list, $value);
    }

    /**
     * @return Tags\Form
     */
    public function open()
    {
        return new Tags\Form();
    }

    /**
     * @return string
     */
    public function close()
    {
        return Tags\Form::close();
    }

    /**
     * @param string $arg
     * @return string
     */
    public function formGroup($arg='')
    {
        $html = '<div class="form-group">';
        $args = func_get_args();
        foreach($args as $element) {
            $html .= $element;
        }
        $html .= "\n</div>";
        return $html;
    }
}