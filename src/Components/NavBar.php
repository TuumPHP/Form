<?php
namespace Tuum\Form\Components;

class NavBar
{
    /**
     * @var string[]
     */
    private $current = [];

    /**
     * @var string[]
     */
    private $items;

    public $onItem = ' active';

    public $offItem = '';

    /**
     * NavBar constructor.
     *
     * @param string $menu1
     */
    public function __construct($menu1)
    {
        $this->current = func_get_args();
    }

    /**
     * @param string $menu1
     * @return NavBar
     */
    public function m($menu1)
    {
        $self = clone($this);
        $self->items = func_get_args();

        return $self;
    }

    /**
     * @param string $string
     * @return $this
     */
    public function on($string)
    {
        $this->onItem = $string;
        return $this;
    }

    /**
     * @param string $string
     * @return $this
     */
    public function off($string)
    {
        $this->offItem = $string;
        return $this;
    }

    /**
     * @return bool
     */
    public function is()
    {
        foreach($this->items as $key => $item) {
            if (!array_key_exists($key, $this->current) ||
                $this->current[$key] !== $item) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->is()) {
            return $this->onItem;
        }
        return $this->offItem;
    }
}