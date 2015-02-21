<?php
namespace Tuum\Form\Format;

use Closure;

class YearList
{
    /**
     * @var Closure
     */
    private $list;

    /**
     * @var Closure
     */
    private $format;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->format = function($year) {
            return sprintf('%04d', $year);
        };
    }

    /**
     * @param Closure $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * use Japanese Gen-Gou style year format.
     */
    public function useJpnGenGou()
    {
        $genGou = [ // until => genGou name
            '1868' => false,
            '1911' => '明治',
            '1925' => '大正',
            '1988' => '昭和',
            '9999' => '平成', // so far...
        ];
        $this->format = function($year) use($genGou) {
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
    
    /**
     * @param int|null $start
     * @param int|null $end
     * @param int      $step
     * @return Closure
     */
    public function setList($start=null, $end=null, $step=1)
    {
        $start = $start ?: date('Y') - 1;
        $end   = $end   ?: date('Y') + 1;
        $this->list = function() use($start, $end, $step) {
            $step  = $start < $end ? abs($step) : -abs($step);
            $years = [];
            $formatter = $this->format;
            for($y = $start; $y <=$end; $y+=$step) {
                $years[$y] = $formatter($y);
            }
            return $years;
        };
        return $this->list;
    }

    /**
     * @return Closure
     */
    public function getList()
    {
        return $this->list ?: $this->setList();
    }

    /**
     * @return callable
     */
    public function getFormat()
    {
        return $this->format;
    }
}