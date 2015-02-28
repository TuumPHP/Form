<?php
namespace Tuum\Form\Lists;

class DayList extends AbstractList
{
    /**
     * @param null|int $start
     * @param null|int $end
     * @param int      $step
     * @return YearList|static
     */
    public static function forge($start=null, $end=null, $step=1)
    {
        $start = $start ?: 1;
        $end   = $end   ?: 31;
        $step  = $start < $end ? abs($step) : -abs($step);
        $list = new self($start, $end, $step);
        $list->setFormat(function($day) {
            return sprintf('%2d', $day);
        });
        return $list;
    }
}
