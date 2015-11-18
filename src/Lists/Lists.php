<?php
namespace Tuum\Form\Lists;

class Lists extends AbstractList
{

    /**
     * @param null|int $start
     * @param null|int $end
     * @param int      $step
     * @return ListInterface
     */
    public static function forge($start = null, $end = null, $step = 1)
    {
        return new self($start ?: 1, $end ?: 10, $step);
    }
}