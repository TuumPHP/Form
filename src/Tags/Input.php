<?php
namespace Tuum\Form\Tags;

/**
 * Class Input
 *
 * @package Tuum\Form
 *
 * @method $this value(string $value)
 * @method $this id(string $id)
 * @method $this required()
 * @method $this checked()
 * @method $this max(int $max)
 * @method $this maxlength(int $length)
 * @method $this pattern(string $pattern)
 * @method $this placeholder(string $holder)
 * @method $this readonly()
 * @method $this size(int $size)
 * @method $this step()
 * @method $this onclick(string $class)
 */
class Input extends Tag
{
    /**
     * @var bool
     */
    private $multiple = false;

    /**
     * @var string
     */
    private $label;

    /**
     * @param string $type
     * @param string $name
     */
    public function __construct($type, $name)
    {
        parent::__construct('input');
        $this->setAttribute('type', $type);
        $this->setAttribute('name', $name);
    }
    
    /**
     * @return string
     */
    public function toString()
    {
        $html = parent::toString();
        if($this->label) {
            $html = (string) (new Tag('label'))->contents($html);
        }
        return $html;
    }

    /**
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple($multiple=true)
    {
        $this->multiple = $multiple;
        return $this;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function label( $label )
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return $this
     */
    public function imeOn()
    {
        return $this->style('ime-mode', 'active');
    }

    /**
     * @return $this
     */
    public function imeOff()
    {
        return $this->style('ime-mode', 'inactive');
    }

    /**
     * @param string $width
     * @return $this
     */
    public function width($width)
    {
        return $this->style('width', $width);
    }

    /**
     * @param string $height
     * @return $this
     */
    public function height($height)
    {
        return $this->style('height', $height);
    }
    
    /**
     * @return mixed
     */
    public function getName()
    {
        $name = $this->get('name');
        if ( $this->multiple ) {
            $name .=  '[]';
        }
        return $name;
    }

    /**
     * @return mixed|null|string
     */
    public function getId()
    {
        if($id = $this->get('id')) {
            return $id;
        }
        $id = $this->getName();
        $id = str_replace(['[', ']', '_'], '-', $id);
        if ( in_array( $this->get('type'), [ 'radio', 'checkbox' ] ) ) {
            $id .= '-' . $this->get('value');
        }
        return $id;
    }
}