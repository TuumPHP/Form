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
        $prop = self::htmlProperty($element);
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
     * @param Tag $element
     * @return string
     * @internal param $type
     * @internal param $name
     * @internal param $id
     */
    private static function htmlProperty($element)
    {
        if ($attributes = $element->getAttribute()) {
            $property = [];
            foreach ($attributes as $key => $val) {
                if (is_numeric($key)) {
                    $property[] = $val;
                } elseif ($val === true) {
                    $property[] = $key;
                } elseif ($val === false) {
                    // ignore this attribute.
                } else {
                    $property[] = $key . "=\"{$val}\"";
                }
            }
            return ' ' . implode(' ', $property);
        }
        return '';
    }
}