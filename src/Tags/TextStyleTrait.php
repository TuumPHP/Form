<?php
namespace Tuum\Form\Tags;

trait TextStyleTrait
{
    abstract function style($name, $style = null);

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
