<?php
namespace Tuum\Form\Lists;

class GenericList extends AbstractList
{
    /**
     * @param null|int $start
     * @param null|int $end
     * @param int      $step
     * @return GenericList
     */
    public static function forge($start = null, $end = null, $step = 1)
    {
        return new self($start, $end, $step);
    }
}