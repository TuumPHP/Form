<?php
namespace Tuum\Form;

use Closure;
use Tuum\Form\Format\DayList;
use Tuum\Form\Format\HourList;
use Tuum\Form\Format\MinuteList;
use Tuum\Form\Format\MonthList;
use Tuum\Form\Format\SecondList;
use Tuum\Form\Format\YearList;
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
     * constructor
     */
    public function __construct()
    {
    }

    /**
     * @param string     $name
     * @param null|Closure|array $years
     * @return Select
     */
    public function selYear($name, $years=null)
    {
        $years = $years ?: YearList::forge();
        return new Select($name, $years);
    }

    /**
     * @param string $name
     * @param array  $dates
     * @return Select
     */
    public function selDay($name, $dates=null)
    {
        $days = $dates ?: DayList::forge();
        return new Select($name, $days);
    }

    /**
     * @param string     $name
     * @param null|Closure|array $months
     * @return Select
     */
    public function selMonth($name, $months=null)
    {
        $months = $months ?: MonthList::forge();
        return new Select($name, $months);
    }

    /**
     * @param string     $name
     * @param null|Closure|array $hour
     * @return Select
     */
    public function selHour($name, $hour=null)
    {
        $hour = $hour ?: HourList::forge();
        return new Select($name, $hour);
    }

    /**
     * @param string     $name
     * @param null|Closure|array $minutes
     * @return Select
     */
    public function selMinute($name, $minutes=null)
    {
        $minutes = $minutes ?: MinuteList::forge();
        return new Select($name, $minutes);
    }

    /**
     * @param string     $name
     * @param null|Closure|array $seconds
     * @return Select
     */
    public function selSecond($name, $seconds=null)
    {
        $seconds = $seconds ?: SecondList::forge();
        return new Select($name, $seconds);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @return Composite
     */
    public function dateYMD($name, $value=null)
    {
        $fields = [
            'y' => $this->selYear($name),
            'm' => $this->selMonth($name),
            'd' => $this->selDay($name),
        ];
        return (new Composite($name, $fields, '%1$s/%2$s/%3$s'))->value($value);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @return Composite
     */
    public function dateYM($name, $value=null)
    {
        $fields = [
            'y' => $this->selYear($name),
            'm' => $this->selMonth($name),
        ];
        return (new Composite($name, $fields, '%1$s/%2$s'))->value($value);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @return Composite
     */
    public function timeHi($name, $value=null)
    {
        $fields = [
            'h' => $this->selHour($name),
            'i' => $this->selMinute($name),
        ];
        return (new Composite($name, $fields, '%1$s:%2$s'))->value($value);

    }
}