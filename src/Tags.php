<?php
namespace Tuum\Form;

//use WScore\Form\Format\ToString;

use Tuum\Form\Format\ToString;

class Tags
{
    /**
     * @var string
     */
    protected $tagName;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var array
     */
    protected $class = array();

    /**
     * @var array
     */
    protected $style = array();

    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * @var bool
     */
    protected $closed = false;

    /**
     * @var ToString
     */
    protected $toString;

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
     * @param string $class
     * @return $this
     */
    public function class_( $class )
    {
        if ( $class === false ) {
            $this->class = array();
        }
        else {
            $this->class[ ] = $class;
        }
        return $this;
    }

    /**
     * @param string $key
     * @param string $style
     * @return $this
     */
    public function style( $key, $style = null )
    {
        if ( $key === false ) {
            $this->style[ ] = array();
        }
        elseif ( $style ) {
            $this->style[ ] = "{$key}:$style";
        }
        else {
            $this->style[ ] = $key;
        }
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    protected function setAttribute( $key, $value )
    {
        $this->attributes[ $key ] = $value;
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
     * @return string
     */
    public function getClass()
    {
        return implode( ' ', $this->class );
    }

    /**
     * @return string
     */
    public function getStyle()
    {
        return implode( '; ', $this->style );
    }

    /**
     * @return string
     */
    public function getAttribute()
    {
        $attribute = [ ];
        foreach ( $this->attributes as $key => $val ) {
            if ( is_numeric( $key ) ) {
                $attribute[ ] = $val;
            }
            elseif ( $val === true ) {
                $attribute[ ] = $key;
            }
            elseif ( $val === false ) {
                // ignore this attribute.
            }
            else {
                $attribute[ ] = $key . "=\"{$val}\"";
            }
        }
        return implode( ' ', $attribute );
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
    // +----------------------------------------------------------------------+
}