<?php
namespace Tuum\Form\Tags;

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
        $html = $this->convertToString($this);
        if ($this->label) {
            $html = $this->labelHtml($html . ' ' . $this->label);
        }
        return $html;
    }
}