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
    public static function forge($start = null, $end = null, $step = 1)
    {
        return new self(
            $start ?: 1,
            $end ?: 31,
            $step,
            function ($day) {
                return sprintf('%2d', $day);
            });
    }
}
