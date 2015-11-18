<?php
namespace Tuum\Form\Tags;

use Traversable;

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
     * @var array|Traversable
     */
    private $list;

    /**
     * @var string
     */
    private $head = null;

    /**
     * @param string            $name
     * @param array|Traversable $list
     * @param null              $value
     */
    public function __construct($name, $list, $value = null)
    {
        parent::__construct('select');
        $this->list = $list;
        $this->setAttribute('name', $name);
        $this->setAttribute('value', (array)$value);
    }

    /**
     * @return array|Traversable
     */
    public function getList()
    {
        return $this->list;
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
        $selectedValue = (array)$this->get('value');
        $this->setAttribute('value', false);
        $html = $this->formOptions($this->list, $selectedValue, $this->head);
        if ($html) {
            $this->contents($html . "\n");
            $html = TagToString::format($this);
        }
        return $html;
    }

    /**
     * @param array             $list
     * @param array|Traversable $selectedValue
     * @param string            $head
     * @return string
     */
    private function formOptions($list, $selectedValue, $head)
    {
        $html = '';
        if (!is_null($head)) {
            $html .= "\n  <option value=\"\">{$head}</option>";
        }
        foreach ($list as $value => $label) {
            if (in_array((string)$value, $selectedValue)) {
                $html .= "\n  <option value=\"{$value}\" selected>{$label}</option>";
            } else {
                $html .= "\n  <option value=\"{$value}\">{$label}</option>";
            }
        }
        return $html;
    }
}