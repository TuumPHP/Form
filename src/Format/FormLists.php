<?php
namespace Tuum\Form\Format;

use Tuum\Form\Tags\Lists;

class FormLists
{
    /**
     * @param ToString $toString
     */
    public function __construct($toString)
    {
        $this->toString = $toString;
    }

    /**
     * @param Lists $element
     * @return mixed
     */
    public function format($element)
    {
        if( 'select' == $element->getTagName() ) {
            return $this->formSelect( $element );
        }

    }
    
    /**
     * @param Lists $element
     * @return string
     */
    public function formSelect( $element )
    {
        $lists = $element->getLists();
        $selectedValue = $element->get('value');
        $html  = '';
        foreach( $lists as $value => $label ) {
            $html .= "\n";
            if( $selectedValue == $value ) {
                $html .= "  <option value=\"{$value}\" selected>{$label}</option>";
            } else {
                $html .= "  <option value=\"{$value}\">{$label}</option>";
            }
        }
        if( $html ) {
            $element->contents($html."\n");
            $html = (string) $this->toString->format($element);
        }
        return $html;
    }
}