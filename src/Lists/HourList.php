<?php
namespace Tuum\Form\Lists;

class HourList extends AbstractList
{
    protected $start = 0;
    protected $end = 23;

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
            function ($hour) {
                return sprintf('%02d', $hour);
            });
    }
}
