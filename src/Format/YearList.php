<?php
namespace Tuum\Form\Format;

use Closure;

class YearList extends AbstractList
{
    /**
     * @param null|int $start
     * @param null|int $end
     * @param int      $step
     * @return YearList|static
     */
    public static function forge($start=null, $end=null, $step=1)
    {
        $start = $start ?: date('Y') - 1;
        $end   = $end   ?: date('Y') + 1;
        $step  = $start < $end ? abs($step) : -abs($step);
        $list = new self($start, $end, $step);
        $list->setFormat(function($year) {
            return sprintf('%04d', $year);
        });
        return $list;
    }

    /**
     * @return Closure
     */
    public static function formatJpnGenGou()
    {
        $genGou = [ // until => genGou name
            '1868' => false,
            '1911' => '明治',
            '1925' => '大正',
            '1988' => '昭和',
            '9999' => '平成', // so far...
        ];
        return function($year) use($genGou) {
            $year = (string) $year;
            $start = 0;
            foreach($genGou as $ends => $gou) {
                if ($year <= $ends) {
                    if(!$gou) {
                        break;
                    }
                    $year = $year - $start;
                    if ($year == 1) {
                        $year = '元';
                    }
                    return $gou . $year . '年';
                }
                $start = $ends;
            }
            return '西暦'.$year . '年';
        };
    }
    
}