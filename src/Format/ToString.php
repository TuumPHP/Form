<?php
namespace Tuum\Form\Format;

use Tuum\Form\Tags\Tag;

class ToString
{
    /**
     * @param Tag $element
     * @return string
     */
    public function format( $element )
    {
        $prop = $this->htmlProperty($element);
        $tag  = $element->getTagName();
        if($element->isClosed() || $element->hasContents()) {
            $html = '<' . $tag . $prop . ' >' . $element->getContents() . "</{$tag}>". "\n";
        } else {
            $html = '<' . $tag . $prop . ' >' . "\n";
        }
        $html = rtrim($html);
        return $html;
    }

    /**
     * @param Tag $element
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
            return ' ' . implode( ' ', $property );
        }
        return '';
    }
}