<?php
namespace Tuum\Form\Lists;

class SecondList extends AbstractList
{
    protected $start = 0;
    protected $end = 59;

    /**
     * @param null|int $start
     * @param null|int $end
     * @param int      $step
     * @return SecondList|static
     */
    public static function forge($start = null, $end = null, $step = 15)
    {
        return new self($start, $end, $step, 
            function ($sec) {
                return sprintf('%02d', $sec);
            }
        );
    }
}
