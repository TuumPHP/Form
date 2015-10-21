<?php
namespace Tuum\Form\Lists;

use Closure;

class YearList extends AbstractList
{
    /**
     * @param null|int $start
     * @param null|int $end
     * @param int      $step
     * @return YearList|static
     */
    public static function forge($start = null, $end = null, $step = 1)
    {
        return new self(
            $start ?: date('Y') - 1,
            $end ?: date('Y') + 1,
            $step,
            function ($year) {
                return sprintf('%04d', $year);
            });
    }

    /**
     * uses Japanese Gen-Gou style year, like '平成21年'.
     *
     * @return $this
     */
    public function useJpnGenGou()
    {
        return $this->setFormat(self::formatJpnGenGou());
    }

    /**
     * @return Closure
     */
    public static function formatJpnGenGou()
    {
        $genGou = [ // until => genGou name
            '1868' => false, // end of genGou, specified by false.
            '1911' => '明治',
            '1925' => '大正',
            '1988' => '昭和',
            '9999' => '平成', // so far...
        ];
        return function ($year) use ($genGou) {
            $year  = (int) $year;
            $start = 0;
            /** @var string|bool $gou */
            foreach ($genGou as $ends => $gou) {
                if ($year <= $ends) {
                    if ($gou === false) {
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
            return '西暦' . $year . '年';
        };
    }

}