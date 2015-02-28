<?php
namespace Tuum\Form\Format;

class HourList extends AbstractList
{
    /**
     * @param null|int $start
     * @param null|int $end
     * @param int      $step
     * @return YearList|static
     */
    public static function forge($start=null, $end=null, $step=1)
    {
        $start = $start ?: 0;
        $end   = $end   ?: 23;
        $step  = $start < $end ? abs($step) : -abs($step);
        $list = new self($start, $end, $step);
        $list->setFormat(function($hour) {
            return sprintf('%02d', $hour);
        });
        return $list;
    }
}
