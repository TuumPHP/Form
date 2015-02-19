<?php
namespace Tuum\Form;

use Tuum\Form\Tags\Composite;
use Tuum\Form\Tags\Select;

class Date
{
    /**
     * @param      $name
     * @param null $value
     * @param null $start
     * @param null $end
     * @return mixed
     */
    public function selYear($name, $value=null, $start=null, $end=null)
    {
        $start = $start ?: date('Y') - 1;
        $end   = $end   ?: date('Y') + 1;
        $years = [];
        for($y = $start; $y <=$end; $y++) {
            $years[$y] = sprintf('%04d', $y);
        }
        return new Select($name, $years, $value);
    }

    /**
     * @param      $name
     * @param null $value
     * @return mixed
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
     * @return mixed
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
     * @return mixed
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