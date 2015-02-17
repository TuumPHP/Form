<?php
namespace Tuum\Form;

use Tuum\Form\Format\ToString;

/**
 * Class Tags
 *
 * @package Tuum\Form
 *          
 * @method $this class($class_name)
 */
class Tags
{
    /**
     * @var string
     */
    private $tagName;

    /**
     * @var string
     */
    private $label;

    /**
     * @var array
     */
    private $attributes = array();

    /**
     * @var bool
     */
    private $closed = false;

    /**
     * @var ToString
     */
    private $toString;

    /**
     * @var string
     */
    private $value;

    // +----------------------------------------------------------------------+
    //  construction 
    // +----------------------------------------------------------------------+
    /**
     * @param string $tagName
     */
    public function __construct( $tagName )
    {
        $this->tagName = strtolower( $tagName );
        $this->toString = new ToString();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->toString->format( $this );
    }

    /**
     * @return $this
     */
    public function closeTag()
    {
        $this->closed = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function isClosed()
    {
        return $this->closed;
    }

    // +----------------------------------------------------------------------+
    //  setting up
    // +----------------------------------------------------------------------+
    /**
     * @param array $options
     * @return $this
     */
    public function apply( $options )
    {
        foreach( $options as $name => $opt ) {
            if( is_numeric( $name ) ) {
                $this->setAttribute( $opt, true );
            } else {
                $this->$name( $opt );
            }
        }
        return $this;
    }

    /**
     * @param string $method
     * @param array  $args
     * @return $this
     */
    public function __call( $method, $args )
    {
        $method = $this->cleanMethod( $method );
        if ( $method === 'class' ) $method = 'class_';
        if ( method_exists( $this, $method ) ) {
            return $this->$method( $args[ 0 ] );
        }
        if ( isset( $args[ 0 ] ) ) {
            return $this->setAttribute( $method, $args[ 0 ] );
        }
        return $this->setAttribute( $method, true );
    }

    /**
     * @param string $method
     * @return string
     */
    protected function cleanMethod( $method )
    {
        if ( false === ( $pos = strpos( $method, '.' ) ) ) {
            return $method;
        }
        return substr( $method, 0, $pos );
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
     * @param string $value
     * @return $this
     */
    public function value($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param string $class
     * @return $this
     */
    public function class_( $class )
    {
        return $this->setAttribute('class', $class, ' ');
    }

    /**
     * @param string $key
     * @param string $style
     * @return $this
     */
    public function style( $key, $style = null )
    {
        $style = $style ? "{$key}:$style" : $key;
        return $this->setAttribute('style', $style, '; ');
    }

    /**
     * @param string $key
     * @param string $value
     * @param bool|string   $sep
     * @return $this
     */
    protected function setAttribute( $key, $value, $sep=false )
    {
        if(!isset($this->attributes[ $key ])) {
            $this->attributes[ $key ] = $value;
        } elseif($sep === false) {
            $this->attributes[ $key ] = $value;
        } else {
            $sep = (string) $sep;
            $this->attributes[ $key ] .= $sep . $value;
        }
        return $this;
    }

    // +----------------------------------------------------------------------+
    //  getting information
    // +----------------------------------------------------------------------+
    /**
     * @param string $key
     * @return null|string
     */
    public function get( $key )
    {
        return array_key_exists( $key, $this->attributes ) ? $this->attributes[ $key ] : null;
    }

    /**
     * @return string
     */
    public function getTagName()
    {
        return $this->tagName;
    }

    /**
     * @return array
     */
    public function getAttribute()
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    // +----------------------------------------------------------------------+
}