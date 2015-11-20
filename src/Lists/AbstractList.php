<?php
namespace Tuum\Form\Lists;

use ArrayIterator;
use Closure;
use IteratorAggregate;
use Traversable;

abstract class AbstractList implements IteratorAggregate
{
    /**
     * @var int
     */
    protected $start;

    /**
     * @var int
     */
    protected $end;

    /**
     * @var int
     */
    protected $step = 1;

    /**
     * @var Closure    format output string (i.e. '2' => 'February').
     */
    protected $format;

    /**
     * @var string     format string for values (i.e. '2' => '02').
     */
    public $formatValue = '%02d';

    /**
     * constructor
     *
     * @param int          $start
     * @param int          $end
     * @param int          $step
     * @param null|Closure $format
     */
    protected function __construct($start, $end, $step, $format = null)
    {
        $this->start  = $start;
        $this->end    = $end;
        $step         = $step ?: $this->step;
        $this->step   = (int) ($start < $end ? abs($step) : -abs($step));
        $this->format = $format;
    }

    /**
     * @param Closure $format
     * @return $this
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @param mixed $value
     * @return string
     */
    public function format($value)
    {
        if ($format = $this->format) {
            return $format($value);
        }
        return $value;
    }

    /**
     * @return callable
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return array
     */
    protected function getList()
    {
        $years = [];
        $cmp   = function ($y) {
            if ($this->step > 0) {
                return $y <= $this->end;
            }
            if ($this->step < 0) {
                return $y >= $this->end;
            }
            return false;
        };
        for ($y = $this->start; $cmp($y); $y += $this->step) {
            $years[sprintf($this->formatValue,$y)] = $this->format($y);
        }
        return $years;
    }

    /**
     * @return Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getList());
    }

    /**
     * use formatted print for output.
     *
     * @param string $fmt
     * @return $this
     */
    public function usePrintFormat($fmt)
    {
        return $this->setFormat(function($string) use($fmt) {
            return sprintf($fmt, $string);
        });
    }
}