<?php
namespace Tuum\Form\Lists;

use Closure;

class MonthList extends AbstractList
{
    /**
     * @param null|int $start
     * @param null|int $end
     * @param int      $step
     * @return MonthList|static
     */
    public static function forge($start = 1, $end = 12, $step = 1)
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
     * uses full-text of month name, like 'January'.
     *
     * @return $this
     */
    public function useFullText()
    {
        return $this->setFormat(self::formatFullText());
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
