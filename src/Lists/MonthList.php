<?php
namespace Tuum\Form\Lists;

use Closure;

class MonthList extends AbstractList
{
    /**
     * @param null|int $start
     * @param null|int $end
     * @param int      $step
     * @return YearList|static
     */
    public static function forge($start = null, $end = null, $step = 1)
    {
        $start = $start ?: 1;
        $end   = $end ?: 12;
        $step  = $start < $end ? abs($step) : -abs($step);
        $list  = new self($start, $end, $step);
        $list->setFormat(function ($month) {
            return sprintf('%2d', $month);
        });
        return $list;
    }

    /**
     * @return Closure
     */
    public static function formatFullText()
    {
        return function ($m) {
            $list = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ];
            return $list[--$m];
        };
    }
}
