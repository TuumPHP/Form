<?php
namespace Tuum\Form;

use Closure;
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
     * @var YearList
     */
    private $yearList;

    /**
     * @var Closure
     */
    private $monthList;

    /**
     * @var Closure
     */
    private $hourList;

    /**
     * @var Closure
     */
    private $minuteList;

    /**
     * @var Closure
     */
    private $secondList;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->yearList = new YearList();
    }

    /**
     * @return YearList
     */
    public function getYearList()
    {
        return $this->yearList;
    }

    /**
     * @return callable
     */
    public function listMonth()
    {
        $this->monthList = function() {
            $months = [];
            for($m = 1; $m <=12; $m++) {
                $months[$m] = sprintf('%02d', $m);
            }
            return $months;
        };
        return $this->monthList;
    }

    /**
     * @return callable
     */
    public function listHour()
    {
        $this->hourList = function() {
            $hours = [];
            for($h = 0; $h < 24; $h++) {
                $hours[$h] = sprintf('%02d', $h);
            }
            return $hours;
        };
        return $this->hourList;
    }

    /**
     * @param int $interval
     * @return callable
     */
    public function listMinute($interval=5)
    {
        $this->minuteList = function() use($interval) {
            $minutes = [];
            for($m = 0; $m <=59; $m+=$interval) {
                $minutes[$m] = sprintf('%02d', $m);
            }
            return $minutes;
        };
        return $this->minuteList;
    }

    /**
     * @param int $interval
     * @return callable
     */
    public function listSecond($interval=15)
    {
        $this->secondList = function() use($interval) {
            $seconds = [];
            for($s = 0; $s <=59; $s+=$interval) {
                $seconds[$s] = sprintf('%02d', $s);
            }
            return $seconds;
        };
        return $this->secondList;
    }

    /**
     * @param string     $name
     * @param null|Closure|array $years
     * @return Select
     */
    public function selYear($name, $years=null)
    {
        $years = $years ?: $this->yearList->getList();
        return new Select($name, $years);
    }

    /**
     * @param string     $name
     * @param null|Closure|array $months
     * @return Select
     */
    public function selMonth($name, $months=null)
    {
        $months = $months ?: $this->listMonth();
        return new Select($name, $months);
    }

    /**
     * @param string     $name
     * @param null|Closure|array $hour
     * @return Select
     */
    public function selHour($name, $hour=null)
    {
        $hour = $hour ?: $this->listHour();
        return new Select($name, $hour);
    }

    /**
     * @param string     $name
     * @param null|Closure|array $minutes
     * @return Select
     */
    public function selMinute($name, $minutes=null)
    {
        $minutes = $minutes ?: $this->listMinute();
        return new Select($name, $minutes);
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