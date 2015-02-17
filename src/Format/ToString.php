<?php
namespace Tuum\Form\Format;

use Tuum\Form\Tags;

class ToString
{
    /**
     * @param Tags $element
     * @return string
     */
    public function format( $element )
    {
        $html = $this->htmlProperty($element, 'class', 'style');
        $html = '<' . $element->getTagName() . ' ' . $html . ' >' . "\n";
        $html = ToString::addLabel( $html, $element );
        return $html;
    }

    /**
     * @param Tags $element
     * @return string
     * @internal param $type
     * @internal param $name
     * @internal param $id
     */
    public function htmlProperty( $element )
    {
        $args = func_get_args();
        array_shift( $args );
        $property = [];
        foreach( $args as $key ) {
            $getter = 'get' . ucwords( $key );
            if( method_exists( $element, $getter ) ) {
                $value = $element->$getter();
            } else {
                $value = $element->get( $key );
            }
            if( "$value"!="" ) {
                $property[] = $key . "=\"{$value}\"";
            }
        }
        if( $attribute = $element->getAttribute() ) {
            $property[] = $attribute;
        }
        $property = array_values( $property );
        $html = implode( ' ', $property );
        return $html;
    }

    /**
     * @param string $html
     * @param Tags $element
     * @return string
     */
    public function addLabel( $html, $element )
    {
        if( $label = $element->getLabel() ) {
            $html = "<label>{$html} {$label}</label>";
        }
        return $html;
    }
}