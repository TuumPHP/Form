<?php
namespace Tuum\Form\Lists;

use ArrayIterator;
use Closure;
use IteratorAggregate;
use Traversable;

abstract class AbstractList implements ListInterface, IteratorAggregate
{
    /**
     * @var int
     */
    protected $start = 1;

    /**
     * @var int
     */
    protected $end = 10;

    /**
     * @var int
     */
    protected $step = 1;

    /**
     * @var Closure
     */
    protected $format;

    /**
     * constructor
     *
     * @param int  $start
     * @param int  $end
     * @param int  $step
     * @param null|Closure $format
     */
    protected function __construct($start, $end, $step, $format=null)
    {
        $this->start = $start ?: $this->start;
        $this->end   = $end ?: $this->end;
        $step = $step ?: $this->step;
        $this->step  = (int) $start < $this->end ? abs($step) : -abs($step);
        $this->format = $format;
    }

    /**
     * @return array
     */
    public function __invoke()
    {
        return $this->getList();
    }

    /**
     * @param null|int $start
     * @param null|int $end
     * @param null|int $step
     * @return static
     */
    public function range($start=null, $end=null, $step=null)
    {
        if(!is_null($start)) $this->start = $start;
        if(!is_null($end))   $this->end   = $end;
        if(!is_null($step))  $this->step  = $step;
        return $this;
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
        if($format = $this->format) {
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
        $cmp = function($y) {
            if( $this->step > 0 ) {
                return $y <= $this->end;
            }
            if( $this->step < 0 ) {
                return $y >= $this->end;
            }
            return false;
        };
        for($y = $this->start; $cmp($y); $y+=$this->step) {
            $years[$y] = $this->format($y);
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
}