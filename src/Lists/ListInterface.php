<?php
namespace Tuum\Form\Lists;

use Closure;

interface ListInterface
{
    /**
     * @return array
     */
    public function __invoke();

    /**
     * @param null|int $start
     * @param null|int $end
     * @param int      $step
     * @return ListInterface
     */
    public static function forge($start = null, $end = null, $step = 1);

    /**
     * @param null|int $start
     * @param null|int $end
     * @param null|int $step
     * @return static
     */
    public function range($start = null, $end = null, $step = null);

    /**
     * @param Closure $format
     * @return static
     */
    public function setFormat($format);
}