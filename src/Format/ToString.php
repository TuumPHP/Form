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
        $html = $this->htmlProperty($element);
        $tag  = $element->getTagName();
        if($element->isClosed()) {
            $html = '<' . $tag . ' ' . $html . ' >' . $element->getValue() . "</{$tag}>". "\n";
        } else {
            $html = '<' . $tag . ' ' . $html . ' >' . "\n";
        }
        $html = rtrim($html);
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
        if( $attributes = $element->getAttribute() ) {
            $property = [];
            foreach ( $attributes as $key => $val ) {
                if ( is_numeric( $key ) ) {
                    $property[ ] = $val;
                }
                elseif ( $val === true ) {
                    $property[ ] = $key;
                }
                elseif ( $val === false ) {
                    // ignore this attribute.
                }
                else {
                    $property[ ] = $key . "=\"{$val}\"";
                }
            }
            return implode( ' ', $property );
        }
        return '';
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