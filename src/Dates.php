<?php
namespace Tuum\Form;

use Traversable;
use Tuum\Form\Data\Inputs;
use Tuum\Form\Lists\DayList;
use Tuum\Form\Lists\HourList;
use Tuum\Form\Lists\MinuteList;
use Tuum\Form\Lists\MonthList;
use Tuum\Form\Lists\SecondList;
use Tuum\Form\Lists\YearList;
use Tuum\Form\Tags\Composite;
use Tuum\Form\Tags\Select;

/**
 * Class Date
 *
 * @package Tuum\Form
 *
 * @property YearList yearList
 */
class Dates
{
    /**
     * @var YearList|Traversable|array
     */
    private $years;

    /**
     * @var MonthList|Traversable|array
     */
    private $months;

    /**
     * @var DayList|Traversable|array
     */
    private $days;

    /**
     * @var HourList|Traversable|array
     */
    private $hours;

    /**
     * @var MinuteList|Traversable|array
     */
    private $minutes;

    /**
     * @var SecondList|Traversable|array
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
     * constructor
     */
    public function __construct()
    {
    }

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
     * sets default class name for composite selects.
     *
     * @param string $class
     * @return Dates
     */
    public function withClass($class)
    {
        $self                = clone($this);
        $self->default_class = $class;
        return $self;
    }

    /**
     * @param YearList|Traversable|array $years
     * @return $this
     */
    public function useYear($years)
    {
        $this->years = $years;
        return $this;
    }

    /**
     * @param MonthList|Traversable|array $months
     * @return $this
     */
    public function useMonth($months)
    {
        $this->months = $months;
        return $this;
    }

    /**
     * @param DayList|Traversable|array $day
     * @return $this
     */
    public function useDay($day)
    {
        $this->days = $day;
        return $this;
    }

    /**
     * @param HourList|Traversable|array $list
     * @return $this
     */
    public function useHour($list)
    {
        $this->hours = $list;
        return $this;
    }

    /**
     * @param MinuteList|Traversable|array $list
     * @return $this
     */
    public function useMinute($list)
    {
        $this->minutes = $list;
        return $this;
    }

    /**
     * @param SecondList|Traversable|array $list
     * @return $this
     */
    public function useSecond($list)
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
        $years = $this->years ?: YearList::forge();
        return $this->makeSelect($name, $years, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selDay($name, $value = null)
    {
        $days = $this->days ?: DayList::forge();
        return $this->makeSelect($name, $days, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selMonth($name, $value = null)
    {
        $months = $this->months ?: MonthList::forge();
        return $this->makeSelect($name, $months, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selHour($name, $value = null)
    {
        $hour = $this->hours ?: HourList::forge();
        return $this->makeSelect($name, $hour, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selMinute($name, $value = null)
    {
        $minutes = $this->minutes ?: MinuteList::forge();
        return $this->makeSelect($name, $minutes, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selSecond($name, $value = null)
    {
        $seconds = $this->seconds ?: SecondList::forge();
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
     * @param string      $name
     * @param string|null $value
     * @param string|null $ymd_format
     * @return Composite
     */
    public function dateYMD($name, $value = null, $ymd_format = null)
    {
        return $this->makeComposite($name,
            [
                'y' => $this->selYear($name),
                'm' => $this->selMonth($name),
                'd' => $this->selDay($name),
            ],
            $ymd_format ?: '%1$s/%2$s/%3$s',
            $value);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @return Composite
     */
    public function dateYM($name, $value = null, $ym_format = null)
    {
        return $this->makeComposite($name,
            [
                'y' => $this->selYear($name),
                'm' => $this->selMonth($name),
            ],
            $ym_format ?: '%1$s/%2$s',
            $value);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @return Composite
     */
    public function timeHi($name, $value = null, $format = null)
    {
        return $this->makeComposite($name,
            [
                'h' => $this->selHour($name),
                'i' => $this->selMinute($name),
            ],
            $format ?: '%1$s:%2$s',
            $value);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @return Composite
     */
    public function timeHis($name, $value = null, $format = null)
    {
        return $this->makeComposite($name,
            [
                'h' => $this->selHour($name),
                'i' => $this->selMinute($name),
                's' => $this->selSecond($name),
            ],
            $format ?: '%1$s:%2$s:%3$s',
            $value);
    }

    /**
     * @param string $name
     * @param array  $fields
     * @param string $format
     * @param string $value
     * @return Composite
     */
    private function makeComposite($name, $fields, $format, $value)
    {
        $value = $this->inputs ? $this->inputs->raw($name, $value) : $value;
        return (new Composite($name, $fields, $format))->value($value);
    }
}