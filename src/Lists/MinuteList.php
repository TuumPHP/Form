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
    public static function forge($start = null, $end = null, $step = 5)
    {
        return new self(
            $start ?: 0,
            $end ?: 59,
            $step,
            function ($min) {
                return sprintf('%02d', $min);
            });
    }
}
