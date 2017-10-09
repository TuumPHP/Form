<?php
namespace Tuum\Form\Tags;

class TagToString
{
    /**
     * @param Tag $element
     * @return string
     */
    public static function format($element)
    {
        $prop = self::htmlProperty($element->getAttribute());
        $tag  = $element->getTagName();
        if ($element->isClosed() || $element->hasContents()) {
            $html = '<' . $tag . $prop . ' >' . $element->getContents() . "</{$tag}>" . "\n";
        } else {
            $html = '<' . $tag . $prop . ' >' . "\n";
        }
        $html = rtrim($html);
        return $html;
    }

    /**
     * @param Attribute $element
     * @return string
     */
    public static function htmlProperty($element)
    {
        if ($attributes = $element->getAttribute()) {
            $property = [];
            foreach ($attributes as $key => $val) {
                if (is_numeric($key)) {
                    $property[] = $val;
                } elseif ($val === true) {
                    $property[] = $key;
                } elseif ($val !== false) {
                    // ignore if $val is false.
                    $property[] = $key . "=\"{$val}\"";
                }
            }
            return ' ' . implode(' ', $property);
        }
        return '';
    }
}