<?php
namespace Tuum\Form\Lists;

class Lists
{
    /**
     * @param int|null $start
     * @param int|null $end
     * @param int      $step
     * @return YearList
     */
    public static function years($start = null, $end = null, $step = 1)
    {
        return YearList::forge($start, $end, $step);
    }

    /**
     * @param int|null $start
     * @param int|null $end
     * @param int      $step
     * @return MonthList
     */
    public static function months($start = 1, $end = 12, $step = 1)
    {
        return MonthList::forge($start, $end, $step);
    }

    /**
     * @param int|null $start
     * @param int|null $end
     * @param int      $step
     * @return GenericList
     */
    public static function days($start = 1, $end = 31, $step = 1)
    {
        return GenericList::forge($start, $end, $step)->setFormat(
            function ($day) {
                return sprintf('%02d', $day);
            });
    }

    /**
     * @param int|null $start
     * @param int|null $end
     * @param int      $step
     * @return GenericList
     */
    public static function hours($start = 0, $end = 23, $step = 1)
    {
        return GenericList::forge($start, $end, $step)->setFormat(
            function ($hour) {
                return sprintf('%02d', $hour);
            });
    }

    /**
     * @param int|null $start
     * @param int|null $end
     * @param int      $step
     * @return GenericList
     */
    public static function minutes($start = 0, $end = 59, $step = 5)
    {
        return GenericList::forge($start, $end, $step)->setFormat(
            function ($min) {
                return sprintf('%02d', $min);
            });
    }

    /**
     * @param int|null $start
     * @param int|null $end
     * @param int      $step
     * @return GenericList
     */
    public static function seconds($start = 0, $end = 59, $step = 15)
    {
        return GenericList::forge($start, $end, $step)->setFormat(
            function ($sec) {
                return sprintf('%02d', $sec);
            });
    }
}