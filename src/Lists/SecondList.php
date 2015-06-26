<?php
namespace Tuum\Form\Lists;

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
        return new self($start ?: 0, $end   ?: 59, $step, function($sec) {
            return sprintf('%02d', $sec);
        });
    }
}
