<?php
namespace Tuum\Form;

use Tuum\Form\Data\Data;
use Tuum\Form\Data\Errors;
use Tuum\Form\Data\Escape;
use Tuum\Form\Data\Inputs;
use Tuum\Form\Data\Message;

/**
 * Class Value
 *
 * @package Tuum\View\DataView
 *
 */
class DataView
{
    /**
     * @var Forms
     */
    public $forms;

    /**
     * @var Dates
     */
    public $dates;
    
    /**
     * @var Data
     */
    public $data;

    /**
     * @var Message
     */
    public $message;

    /**
     * @var Inputs
     */
    public $inputs;

    /**
     * @var Errors
     */
    public $errors;

    /**
     * @var callable|Escape
     */
    public $escape;

    /**
     * @param null|callable $escape
     */
    public function __construct($escape = null)
    {
        if (is_callable($escape)) {
            $this->escape = $escape;
        } else {
            $this->escape = new Escape();
        }
        $this->forms = new Forms();
        $this->dates = new Dates();
    }

    /**
     * @param array|Inputs $inputs
     * @return $this
     */
    public function setInputs($inputs)
    {
        if (is_array($inputs)) {
            $inputs = Inputs::forge($inputs);
        }
        $this->inputs = $inputs;
        if($this->forms) {
            $this->forms = $this->forms->withInputs($inputs);
        }
        if($this->dates) {
            $this->dates = $this->dates->withInputs($inputs);
        }
        return $this;
    }

    /**
     * @param array|Data $data
     * @return $this
     */
    public function setData($data)
    {
        if(is_array($data)) {
            $this->data = new Data($data, $this->escape);
        }
        elseif($data instanceof Data) {
            $this->data = $data;
        }
        return $this;
    }

    /**
     * @param array|Message $messages
     * @return $this
     */
    public function setMessage($messages)
    {
        if(is_array($messages)) {
            $this->message = Message::forge($messages);
        }
        elseif($messages instanceof Message) {
            $this->message = $messages;
        }
        return $this;
    }

    /**
     * @param array|Errors $errors
     * @return $this
     */
    public function setErrors($errors)
    {
        if(is_array($errors)) {
            $this->errors = Errors::forge($errors);
        }
        elseif($errors instanceof Errors) {
            $this->errors = $errors;
        }
        return $this;
    }
}