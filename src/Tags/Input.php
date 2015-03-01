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
    
    use TextStyleTrait;

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
        $html = TagToString::format($this);
        if ($this->label) {
            $html = $this->labelHtml($html . ' ' . $this->label);
        }
        return $html;
    }
}