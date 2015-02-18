<?php
namespace Tuum\Form\Tags;

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
     * @var array
     */
    protected $list = array();

    /**
     * @param string $name
     * @param array  $list
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
        $selectedValue = $this->get('value');
        $this->setAttribute('value', false);
        $html = '';
        foreach ($this->list as $value => $label) {
            if (in_array((string)$value, $selectedValue)) {
                $html .= "\n  <option value=\"{$value}\" selected>{$label}</option>";
            } else {
                $html .= "\n  <option value=\"{$value}\">{$label}</option>";
            }
        }
        if ($html) {
            $this->contents($html . "\n");
            $html = (string)$this->toString->format($this);
        }
        return $html;
    }
}