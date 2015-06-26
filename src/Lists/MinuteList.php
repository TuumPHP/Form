<?php
namespace Tuum\Form\Lists;

class MinuteList extends AbstractList
{
    protected $start = 0;
    protected $end = 59;

    /**
     * @param null|int $start
     * @param null|int $end
     * @param int      $step
     * @return YearList|static
     */
    public static function forge($start = null, $end = null, $step = 5)
    {
        return new self(
            $start,
            $end,
            $step,
            function ($min) {
                return sprintf('%02d', $min);
            });
    }
}
