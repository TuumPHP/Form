<?php
namespace Tuum\Form\Tags;

class Select extends Input
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
        return $this->formSelect();
    }
    
    /**
     * @return string
     */
    private function formSelect()
    {
        $selectedValue = $this->get('value');
        $this->value(false);
        $html  = '';
        foreach( $this->list as $value => $label ) {
            if( $selectedValue === $value ) {
                $html .= "\n  <option value=\"{$value}\" selected>{$label}</option>";
            } else {
                $html .= "\n  <option value=\"{$value}\">{$label}</option>";
            }
        }
        if( $html ) {
            $this->contents($html."\n");
            $html = (string) $this->toString->format($this);
        }
        return $html;
    }
}