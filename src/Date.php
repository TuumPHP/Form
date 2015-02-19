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
        return (new Composite($fields, '%1$s, %2$s'))->name($name)->value($value);
    }
    
    public function timeHi($name, $value)
    {
        
    }
}