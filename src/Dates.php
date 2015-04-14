<?php
namespace Tuum\Form;

use Closure;
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
     * @var YearList
     */
    private $years;

    /**
     * @var MonthList
     */
    private $months;

    /**
     * @var DayList
     */
    private $days;

    /**
     * @var HourList
     */
    private $hours;

    /**
     * @var MinuteList
     */
    private $minutes;

    /**
     * @var SecondList
     */
    private $seconds;

    /**
     * @var Inputs
     */
    private $inputs;

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
        $self = clone($this);
        $self->inputs = $inputs;
        return $self;
    }

    /**
     * @param YearList $years
     * @return $this
     */
    public function useYear($years)
    {
        $this->years = $years;
        return $this;
    }

    /**
     * @param YearList $months
     * @return $this
     */
    public function useMonth($months)
    {
        $this->months = $months;
        return $this;
    }

    /**
     * @param DayList $day
     * @return $this
     */
    public function useDay($day)
    {
        $this->days = $day;
        return $this;
    }

    /**
     * @param HourList $list
     * @return $this
     */
    public function useHour($list)
    {
        $this->hours = $list;
        return $this;
    }

    /**
     * @param MinuteList $list
     * @return $this
     */
    public function useMinute($list)
    {
        $this->minutes = $list;
        return $this;
    }

    /**
     * @param SecondList $list
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
    public function selYear($name, $value=null)
    {
        $years = $this->years ?: YearList::forge();
        return $this->makeSelect($name, $years, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selDay($name, $value=null)
    {
        $days = $this->days ?: DayList::forge();
        return $this->makeSelect($name, $days, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selMonth($name, $value=null)
    {
        $months = $this->months ?: MonthList::forge();
        return $this->makeSelect($name, $months, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selHour($name, $value=null)
    {
        $hour = $this->hours ?: HourList::forge();
        return $this->makeSelect($name, $hour, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selMinute($name, $value=null)
    {
        $minutes = $this->minutes ?: MinuteList::forge();
        return $this->makeSelect($name, $minutes, $value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Select
     */
    public function selSecond($name, $value=null)
    {
        $seconds = $this->seconds ?: SecondList::forge();
        return $this->makeSelect($name, $seconds, $value);
    }

    /**
     * @param string        $name
     * @param array|closure $list
     * @param string        $value
     * @return Select
     */
    private function makeSelect($name, $list, $value)
    {
        $value = $this->inputs ? $this->inputs->raw($name, $value) : $value;
        return new Select($name, $list, $value);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @return Composite
     */
    public function dateYMD($name, $value=null, $format=null)
    {
        $fields = [
            'y' => $this->selYear($name),
            'm' => $this->selMonth($name),
            'd' => $this->selDay($name),
        ];
        $format = $format ?: '%1$s/%2$s/%3$s';
        return $this->makeComposite($name, $fields, $format, $value);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @return Composite
     */
    public function dateYM($name, $value=null, $format=null)
    {
        $fields = [
            'y' => $this->selYear($name),
            'm' => $this->selMonth($name),
        ];
        $format = $format ?: '%1$s/%2$s';
        return $this->makeComposite($name, $fields, $format, $value);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @return Composite
     */
    public function timeHi($name, $value=null, $format=null)
    {
        $fields = [
            'h' => $this->selHour($name),
            'i' => $this->selMinute($name),
        ];
        $format = $format ?: '%1$s:%2$s';
        return $this->makeComposite($name, $fields, $format, $value);
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