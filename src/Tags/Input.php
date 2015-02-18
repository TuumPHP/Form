<?php
namespace Tuum\Form\Tags;

/**
 * Class Input
 *
 * @package Tuum\Form
 *
 * @method $this value(string $value)
 * @method $this required()
 * @method $this checked()
 * @method $this max(int $max)
 * @method $this maxlength(int $length)
 * @method $this pattern(string $pattern)
 * @method $this placeholder(string $holder)
 * @method $this readonly()
 * @method $this size(int $size)
 * @method $this step()
 * @method $this onclick(string $class)
 */
class Input extends Tag
{
    use ElementTrait;

    /**
     * @param string $type
     * @param string $name
     */
    public function __construct($type, $name)
    {
        parent::__construct('input');
        $this->setAttribute('type', $type);
        $this->setAttribute('name', $name);
    }

    /**
     * @return string
     */
    public function toString()
    {
        $html = parent::toString();
        if ($this->label) {
            $html = $this->labelHtml($html . ' ' . $this->label);
        }
        return $html;
    }

    /**
     * @return $this
     */
    public function imeOn()
    {
        return $this->style('ime-mode', 'active');
    }

    /**
     * @return $this
     */
    public function imeOff()
    {
        return $this->style('ime-mode', 'inactive');
    }

    /**
     * @param string $width
     * @return $this
     */
    public function width($width)
    {
        return $this->style('width', $width);
    }

    /**
     * @param string $height
     * @return $this
     */
    public function height($height)
    {
        return $this->style('height', $height);
    }
}