<?php
namespace Tuum\Form\Tags;

use Tuum\Form\Format\FormLists;

class Lists extends Input
{
    /**
     * @var array
     */
    protected $list = array();

    /**
     * @param string $type
     * @param string $name
     * @param array  $list
     * @param null   $value
     */
    public function __construct($type, $name, $list)
    {
        parent::__construct($type, $name);
        $this->list = $list;
        $this->formLists = new FormLists($this->toString);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->formLists->format($this);
    }
    
    /**
     * @param array $list
     */
    public function lists(array $list)
    {
        $this->list = $list;
    }

    /**
     * @return array
     */
    public function getLists()
    {
        return $this->list;
    }
}