<?php
namespace Tuum\Form\Tags;

/**
 * Class TextArea
 *
 * @package Tuum\Form\Tags
 *
 * @method $this value(string $value)
 * @method $this required()
 * @method $this max(int $max)
 * @method $this pattern(string $pattern)
 * @method $this placeholder(string $holder)
 * @method $this readonly()
 * @method $this step()
 * @method $this onclick(string $class)
 */
class TextArea extends Tag
{
    use ElementTrait;

    use TextStyleTrait;

    public function __construct($name)
    {
        parent::__construct('textarea');
        $this->setAttribute('name', $name);
        $this->closeTag();
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