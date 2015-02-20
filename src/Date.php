<?php
namespace Tuum\Form;

use Closure;
use Tuum\Form\Tags\Composite;
use Tuum\Form\Tags\Select;

class Date
{
    /**
     * @var Closure
     */
    private $yearList;

    /**
     * @var Closure
     */
    private $yearFormat;

    /**
     * @var Closure
     */
    private $minuteList;

    /**
     * @var Closure
     */
    private $secondList;
    
    public function __construct()
    {
        $this->yearFormat = function($year) {
            return sprintf('%04d', $year);
        };
    }

    /**
     * @param int|null $start
     * @param int|null $end
     * @param int      $step
     * @return callable
     */
    public function listYears($start=null, $end=null, $step=1)
    {
        $start = $start ?: date('Y') - 1;
        $end   = $end   ?: date('Y') + 1;
        $this->yearList = function() use($start, $end, $step) {
            $step  = $start < $end ? abs($step) : -abs($step);
            $years = [];
            $formatter = $this->yearFormat;
            for($y = $start; $y <=$end; $y+=$step) {
                $years[$y] = $formatter($y);
            }
            return $years;
        };
        return $this->yearList;
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
     * @param      $name
     * @param null $value
     * @return Select
     */
    public function selYear($name, $value=null)
    {
        $years = $this->yearList ?: $this->listYears();
        return new Select($name, $years, $value);
    }

    /**
     * @param      $name
     * @param null $value
     * @return Select
     */
    public function selMonth($name, $value=null)
    {
        $months = [];
        for($m = 1; $m <=12; $m++) {
            $months[$m] = sprintf('%02d', $m);
        }
        return new Select($name, $months, $value);
    }

    /**
     * @param      $name
     * @param null $value
     * @return Select
     */
    public function selTime($name, $value=null)
    {
        $times = [];
        for($t = 0; $t <=23; $t++) {
            $times[$t] = sprintf('%02d', $t);
        }
        return new Select($name, $times, $value);
    }

    /**
     * @param      $name
     * @param null $value
     * @param int  $interval
     * @return Select
     */
    public function selMinute($name, $value=null, $interval=5)
    {
        $minutes = [];
        $interval = $interval ?: 5;
        for($m = 0; $m <=59; $m+=$interval) {
            $minutes[$m] = sprintf('%02d', $m);
        }
        return new Select($name, $minutes, $value);
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
        return (new Composite($fields, '%1$s/%2$s'))->name($name)->value($value);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @return Composite
     */
    public function timeHi($name, $value=null)
    {
        $fields = [
            'h' => $this->selTime($name),
            'i' => $this->selMinute($name),
        ];
        return (new Composite($fields, '%1$s:%2$s'))->name($name)->value($value);

    }
}