<?php
namespace Tuum\Form\Lists;

class MinuteList extends AbstractList
{
    /**
     * @param null|int $start
     * @param null|int $end
     * @param int      $step
     * @return YearList|static
     */
    public static function forge($start=null, $end=null, $step=5)
    {
        $start = $start ?: 0;
        $end   = $end   ?: 59;
        $step  = $start < $end ? abs($step) : -abs($step);
        $list = new self($start, $end, $step);
        $list->setFormat(function($min) {
            return sprintf('%02d', $min);
        });
        return $list;
    }
}
