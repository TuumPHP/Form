<?php
namespace Tuum\Form\Tags;

use Closure;

/**
 * Class Select
 *
 * @package Tuum\Form\Tags
 *
 * @method $this value(string $value)
 * @method $this required()
 * @method $this onclick(string $class)
 */
class Select extends Tag
{
    use ElementTrait;

    /**
     * @var array|Closure
     */
    private $list;

    /**
     * @var string
     */
    private $head;

    /**
     * @param string $name
     * @param array|Closure  $list
     * @param null   $value
     */
    public function __construct($name, $list, $value = null)
    {
        parent::__construct('select');
        $this->list = $list;
        $this->setAttribute('name', $name);
        $this->setAttribute('value', (array) $value);
    }

    /**
     * add an empty selection at the beginning of the list, 
     * such as 'select an item...'. 
     * 
     * @param string $head
     * @return $this
     */
    public function head($head)
    {
        $this->head = $head;
        return $this;
    }
    /**
     * @return string
     */
    public function toString()
    {
        return $this->formSelect();
    }

    /**
     * @return string
     */
    private function formSelect()
    {
        $selectedValue = (array) $this->get('value');
        $this->setAttribute('value', false);
        $html = '';
        if ($this->head) {
            $html .= "\n  <option value=\"\" selected>{$this->head}</option>";
        }
        $list = $this->list;
        if ($list instanceof Closure) {
            $list = $list();
        }
        foreach ($list as $value => $label) {
            if (in_array((string)$value, $selectedValue)) {
                $html .= "\n  <option value=\"{$value}\" selected>{$label}</option>";
            } else {
                $html .= "\n  <option value=\"{$value}\">{$label}</option>";
            }
        }
        if ($html) {
            $this->contents($html . "\n");
            $html = (string)$this->convertToString($this);
        }
        return $html;
    }
}