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
        $prop = (string) $element->getAttribute();
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
                if ($val === false) continue;
                if ($key === 'value' && '' === (string) $val) continue;
                if (is_numeric($key)) {
                    $key = $val;
                } elseif ($val === true) {
                    $val = $key;
                }
                $property[] = "{$key}=\"{$val}\"";
            }
            return ' ' . implode(' ', $property);
        }
        return '';
    }
}