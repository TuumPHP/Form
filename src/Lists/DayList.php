<?php
namespace Tuum\Form\Lists;

class DayList extends AbstractList
{
    protected $start = 1;
    protected $end = 31;

    /**
     * @param null|int $start
     * @param null|int $end
     * @param int      $step
     * @return YearList|static
     */
    public static function forge($start = null, $end = null, $step = 1)
    {
        return new self(
            $start,
            $end,
            $step,
            function ($day) {
                return sprintf('%2d', $day);
            });
    }
}
