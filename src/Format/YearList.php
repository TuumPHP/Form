<?php
namespace Tuum\Form\Format;

use Closure;

class YearList implements ListInterface
{
    /**
     * @var array
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
     * @param null|Closure $format
     * @return YearList
     */
    public static function forge($format=null)
    {
        $list = new self;
        if($format) {
            $list->setFormat($format);
        }
        return $list;
    }

    /**
     * @return array
     */
    public function __invoke()
    {
        return $this->list ?: $this->setYears();
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
    
    /**
     * @param Closure $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @param int|null $start
     * @param int|null $end
     * @param int      $step
     * @return array
     */
    public function setYears($start=null, $end=null, $step=1)
    {
        $start = $start ?: date('Y') - 1;
        $end   = $end   ?: date('Y') + 1;
        $step  = $start < $end ? abs($step) : -abs($step);
        $years = [];
        for($y = $start; $y <=$end; $y+=$step) {
            $years[$y] = $this->format($y);
        }
        $this->list = $years;
        return $this->list;
    }

    /**
     * @param mixed $value
     * @return string
     */
    private function format($value)
    {
        $format = $this->format;
        return $format($value);
    }

    /**
     * @return callable
     */
    public function getFormat()
    {
        return $this->format;
    }
}