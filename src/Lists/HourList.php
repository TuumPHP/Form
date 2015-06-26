<?php
namespace Tuum\Form\Lists;

class HourList extends AbstractList
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
            $start ?: 0,
            $end ?: 23,
            $step,
            function ($hour) {
                return sprintf('%02d', $hour);
            });
    }
}
