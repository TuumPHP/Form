<?php
namespace Tuum\Form;

use Traversable;
use Tuum\Form\Data\Inputs;
use Tuum\Form\Lists\DatesComposer;
use Tuum\Form\Lists\Lists;
use Tuum\Form\Tags\Composite;
use Tuum\Form\Tags\Select;

/**
 * Class Date
 *
 * @package Tuum\Form
 */
class Dates
{
    /**
     * @var Traversable|array
     */
    private $years;

    /**
     * @var Traversable|array
     */
    private $months;

    /**
     * @var Traversable|array
     */
    private $days;

    /**
     * @var Traversable|array
     */
    private $hours;

    /**
     * @var Traversable|array
     */
    private $minutes;

    /**
     * @var Traversable|array
     */
    private $seconds;

    /**
     * @var Inputs
     */
    private $inputs;

    /**
     * @var string
     */
    private $default_class;

    /**
     * @var DatesComposer
     */
    public $datesComposer;

    /**
     * constructor
     *
     * @param array $options
     */
    public function __construct($options = [])
    {
        foreach( ['years', 'months', 'days', 'hours', 'minutes', 'seconds'] as $field) {
            if (isset($options[$field])) {
                $this->$field = $options[$field];
            }
        }
        $this->datesComposer = new DatesComposer($this);
    }

    /**
     * @param Inputs $inputs
     * @return $this
     */
    public function setInputs($inputs)
    {
        $this->inputs = $inputs;
        $this->datesComposer->setInputs($inputs);
        return $this;
    }

    /**
     * sets default class name for composite selects.
     *
     * @param string $class
     * @return Dates
     */
    public function setClass($class)
    {
        $this->default_class = $class;
        return $this;
    }

    /**
     * @param Traversable|array $years
     * @return $this
     */
    public function setYear($years)
    {
        $this->years = $years;
        return $this;
    }

    /**
     * @param Traversable|array $months
     * @return $this
     */
    public function setMonth($months)
    {
        $this->months = $months;
        return $this;
    }

    /**
     * @param Traversable|array $day
     * @return $this
     */
    public function setDay($day)
    {
        $this->days = $day;
        return $this;
    }

    /**
     * @param Traversable|array $list
     * @return $this
     */
    public function setHour($list)
    {
        $this->hours = $list;
        return $this;
    }

    /**
     * @param Traversable|array $list
     * @return $this
     */
    public function setMinute($list)
    {
        $this->minutes = $list;
        return $this;
    }

    /**
     * @param Traversable|array $list
     * @return $this
     */
    public function setSecond($list)
    {
        $this->seconds = $list;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selYear($name, $value = null)
    {
        $years = $this->years ?: Lists::years();
        return $this->makeSelect($name, $years, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selDay($name, $value = null)
    {
        $days = $this->days ?: Lists::days();
        return $this->makeSelect($name, $days, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selMonth($name, $value = null)
    {
        $months = $this->months ?: Lists::months();
        return $this->makeSelect($name, $months, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selHour($name, $value = null)
    {
        $hour = $this->hours ?: Lists::hours();
        return $this->makeSelect($name, $hour, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selMinute($name, $value = null)
    {
        $minutes = $this->minutes ?: Lists::minutes();
        return $this->makeSelect($name, $minutes, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selSecond($name, $value = null)
    {
        $seconds = $this->seconds ?: Lists::seconds();
        return $this->makeSelect($name, $seconds, $value);
    }

    /**
     * @param string            $name
     * @param array|Traversable $list
     * @param string            $value
     * @return Select
     */
    private function makeSelect($name, $list, $value)
    {
        $value  = $this->inputs ? $this->inputs->raw($name, $value) : $value;
        $select = new Select($name, $list, $value);
        if ($this->default_class) {
            $select->class($this->default_class);
        }
        return $select;
    }

    /**
     * @param string $name
     * @param array  $fields
     * @param string $format
     * @param string $value
     * @return Composite
     */
    public function makeComposite($name, $fields, $format, $value)
    {
        $value = $this->inputs ? $this->inputs->raw($name, $value) : $value;
        return (new Composite($name, $fields, $format))->value($value);
    }
    
    /**
     * @param string      $name
     * @param string|null $value
     * @param string|null $ymd_format
     * @return Composite
     */
    public function dateYMD($name, $value = null, $ymd_format = null)
    {
        return $this->datesComposer->dateYMD($name, $value, $ymd_format);
    }
    
    /**
     * @param string      $name
     * @param string|null $value
     * @param string|null $ym_format
     * @return Composite
     */
    public function dateYM($name, $value = null, $ym_format = null)
    {
        return $this->datesComposer->dateYM($name, $value, $ym_format);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @param string|null $hi_format
     * @return Composite
     */
    public function timeHi($name, $value = null, $hi_format = null)
    {
        return $this->datesComposer->timeHi($name, $value, $hi_format);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @param string|null $his_format
     * @return Composite
     */
    public function timeHis($name, $value = null, $his_format = null)
    {
        return $this->datesComposer->timeHis($name, $value, $his_format);
    }
}