<?php
namespace Tuum\Form\Format;

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
     */
    public function setFormat($format)
    {
        $this->format = $format;
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
        for($y = $this->start; $y <=$this->end; $y+=$this->step) {
            $years[$y] = $this->format($y);
        }
        return $years;
    }
}