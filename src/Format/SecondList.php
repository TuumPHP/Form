<?php
namespace Tuum\Form\Format;

class SecondList extends AbstractList
{
    /**
     * @param null|int $start
     * @param null|int $end
     * @param int      $step
     * @return YearList|static
     */
    public static function forge($start=null, $end=null, $step=15)
    {
        $start = $start ?: 0;
        $end   = $end   ?: 59;
        $step  = $start < $end ? abs($step) : -abs($step);
        $list = new self($start, $end, $step);
        $list->setFormat(function($sec) {
            return sprintf('%02d', $sec);
        });
        return $list;
    }
}
