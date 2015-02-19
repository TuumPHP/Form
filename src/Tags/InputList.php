<?php
namespace Tuum\Form\Tags;

class InputList extends Tag
{
    use ElementTrait;

    /**
     * @var array
     */
    private $list = array();

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
        $this->setAttribute('value', (array) $value);
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
        $html          = '<ul>';
        foreach ($this->list as $key => $label) {
            $html .= "\n";
            $html .= '  <li>'.$this->labelHtml($this->getInput($key) . ' ' . $label).'</li>';
        }
        return $html . "\n</ul>";
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getInput($key)
    {
        if (!array_key_exists($key, $this->list)) {
            return '';
        }
        $input = clone($this);
        $input->setAttribute('value', $key);
        $selectedValue = $this->get('value');
        if (in_array((string)$key, $selectedValue) ) {
            $input->setAttribute('checked', true);
        }
        return $this->convertToString($input);
    }
}