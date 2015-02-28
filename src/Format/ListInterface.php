<?php
namespace Tuum\Form\Format;

use Closure;

interface ListInterface
{
    /**
     * @param null|Closure $format
     * @return YearList
     */
    public static function forge($format = null);

    /**
     * @param Closure $format
     */
    public function setFormat($format);
}