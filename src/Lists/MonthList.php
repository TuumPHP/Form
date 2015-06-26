<?php
namespace Tuum\Form\Lists;

use Closure;

class MonthList extends AbstractList
{
    protected $start = 1;
    protected $end = 12;

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
            function ($month) {
                return sprintf('%2d', $month);
            });
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
