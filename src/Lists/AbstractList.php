<?php
namespace Tuum\Form\Lists;

use Closure;

abstract class AbstractList implements ListInterface
{
    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $end;

    /**
     * @var int
     */
    private $step;

    /**
     * @var Closure
     */
    private $format;

    /**
     * constructor
     *
     * @param int $start
     * @param int $end
     * @param int $step
     */
    protected function __construct($start, $end, $step)
    {
        $this->start = $start;
        $this->end   = $end;
        $this->step  = $step;
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
}