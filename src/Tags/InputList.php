<?php
namespace Tuum\Form\Tags;

class InputList extends Input
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
    public function __construct($type, $name, $list, $value=null)
    {
        parent::__construct($type, $name);
        $this->list = $list;
        $this->setAttribute('value', $value);
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
        $html  = '';
        foreach( $this->list as $value => $label ) {
            $html .= "\n";
            $this->label($label);
            $this->value($value);
            if( (string) $selectedValue == (string) $value ) {
                $this->checked();
            } else {
                $this->checked(false);
            }
            $html .= parent::toString();
        }
        return $html;
    }
}