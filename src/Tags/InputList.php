<?php
namespace Tuum\Form\Tags;

class InputList extends Tag
{
    use ElementTrait;

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
    public function __construct($type, $name, $list, $value = null)
    {
        parent::__construct('input');
        $this->list = $list;
        $this->setAttribute('type', $type);
        $this->setAttribute('name', $name);
        $this->setAttribute('value', $value);
        if ($type === 'checkbox') {
            $this->setMultiple();
        }
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->formInput();
    }

    /**
     * @return string
     */
    private function formInput()
    {
        $selectedValue = $this->get('value');
        $html          = '<ul>';
        foreach ($this->list as $value => $label) {
            $html .= "\n";
            $this->label($label);
            $this->setAttribute('value', $value);
            if ((string)$selectedValue == (string)$value) {
                $this->setAttribute('checked', true);
            } else {
                $this->setAttribute('checked', false);
            }
            $html .= '  <li>'.$this->labelHtml(parent::toString() . ' ' . $label).'</li>';
        }
        return $html . "\n</ul>";
    }
}