<?php
namespace Tuum\Form;

use Traversable;
use Tuum\Form\Data\Inputs;
use Tuum\Form\Tags\Attribute;
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
 * @method Input hidden(string $name, string $value = null)
 * @method Input search(string $name, string $value = null)
 * @method Input tel(string $name, string $value = null)
 * @method Input url(string $name, string $value = null)
 * @method Input email(string $name, string $value = null)
 * @method Input password(string $name, string $value = null)
 * @method Input datetime(string $name, string $value = null)
 * @method Input date(string $name, string $value = null)
 * @method Input month(string $name, string $value = null)
 * @method Input week(string $name, string $value = null)
 * @method Input time(string $name, string $value = null)
 * @method Input number(string $name, string $value = null)
 * @method Input range(string $name, string $value = null)
 * @method Input color(string $name, string $value = null)
 * @method Input file(string $name, string $value = null)
 */
class Forms
{
    private $inputTags = [
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
     * @var Inputs
     */
    private $inputs;

    /**
     * @var string
     */
    private $default_class = '';

    /**
     * @param Inputs $inputs
     * @return $this
     */
    public function withInputs($inputs)
    {
        $self         = clone($this);
        $self->inputs = $inputs;
        return $self;
    }

    /**
     * sets default class name for input form elements.
     *
     * @param string $class
     * @return $this
     */
    public function withClass($class)
    {
        $self                = clone($this);
        $self->default_class = $class;
        return $self;
    }

    /**
     * @param Tag $form
     * @return mixed
     */
    private function setClass($form)
    {
        if ($this->default_class) {
            $form->class($this->default_class);
        }
        return $form;
    }

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
        if (in_array($type, $this->inputTags)) {
            if (!array_key_exists(0, $args)) {
                throw new \InvalidArgumentException();
            }
            $name  = $args[0];
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
    public function input($type, $name, $value = null)
    {
        $value = $this->inputs ? $this->inputs->get($name, $value) : $value;
        $form  = (new Input($type, $name))->value($value);
        return $this->setClass($form);
    }

    /**
     * construct Input[type=radio] form element object.
     *
     * @param string $name
     * @param string $value
     * @return Input
     */
    public function radio($name, $value)
    {
        return $this->checkedInput('radio', $name, $value);
    }

    /**
     * construct Input[type=radio] form element object.
     *
     * @param string $name
     * @param string $value
     * @return Input
     */
    public function checkbox($name, $value)
    {
        return $this->checkedInput('checkbox', $name, $value);
    }

    /**
     * @param string $type
     * @param string $name
     * @param string $value
     * @return Input
     */
    private function checkedInput($type, $name, $value)
    {
        $form = (new Input($type, $name))->value($value);
        if ($this->inputs && $this->inputs->exists($name, $value)) {
            $form->checked();
        }
        return $this->setClass($form);
    }

    /**
     * @param string      $label
     * @param null|string $for
     * @return Tag
     */
    public function label($label, $for = null)
    {
        return (new Tag('label'))->contents($label)->setAttribute('for', $for);
    }

    /**
     * @param null $value
     * @return Input
     */
    public function submit($value = null)
    {
        return (new Input('submit', null))->value($value);
    }

    /**
     * @param null $value
     * @return Input
     */
    public function reset($value = null)
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
        $value = $this->inputs ? $this->inputs->raw($name, $value) : $value;
        $form  = (new TextArea($name))->contents($value);
        return $this->setClass($form);
    }

    /**
     * @param string            $name
     * @param array|Traversable $list
     * @param null|string       $value
     * @return Select
     */
    public function select($name, $list, $value = null)
    {
        $value = $this->inputs ? $this->inputs->raw($name, $value) : $value;
        $form  = new Select($name, $list, $value);
        return $this->setClass($form);
    }

    /**
     * @param string            $name
     * @param array|Traversable $list
     * @param null|string       $value
     * @return InputList
     */
    public function checkList($name, $list, $value = null)
    {
        $value = $this->inputs ? $this->inputs->raw($name, $value) : $value;
        return new InputList('checkbox', $name, $list, $value);
    }

    /**
     * @param string            $name
     * @param array|Traversable $list
     * @param null|string       $value
     * @return InputList
     */
    public function radioList($name, $list, $value = null)
    {
        $value = $this->inputs ? $this->inputs->raw($name, $value) : $value;
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
     * @return Tag
     */
    public function formGroup($arg = '')
    {
        $html = "";
        $args = func_get_args();
        foreach ($args as $element) {
            $html .= "\n  " . $element;
        }
        $div = new Tag('div');
        $div->contents($html)->class('form-group');
        return $div;
    }

    /**
     * @param array $attribute
     * @return Attribute
     */
    public function newAttribute(array $attribute = [])
    {
        return new Attribute($attribute);
    }
}
