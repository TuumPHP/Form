<?php
namespace Tuum\Form\Data;

class Errors extends AbstractData
{
    /**
     * @var string
     */
    public $format = '<p class="text-danger">%s</p>';

    /**
     * prints out error message in a format.
     *
     * @param string $name
     * @return string
     */
    public function p($name)
    {
        $msg = $this->raw($name);
        if (!$msg) {
            return '';
        }
        return sprintf($this->format, $msg);
    }
}