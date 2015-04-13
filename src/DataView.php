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
     * @param Inputs $inputs
     */
    protected function setInputs($inputs)
    {
        if($this->forms) {
            $this->forms = $this->forms->withInputs($inputs);
        }
        if($this->dates) {
            $this->dates = $this->dates->withInputs($inputs);
        }
    }
}