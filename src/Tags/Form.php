<?php
namespace Tuum\Form\Tags;

/**
 * Class Form
 *
 * @package WScore\Form
 */
class Form extends Tag
{
    /**
     * @var string
     */
    private $_method = null;
    
    /**
     * list of available *raw* http methods. 
     * other methods are passed as a hidden parameter. 
     * 
     * @var array
     */
    private $http_methods = [ 'get', 'post' ];

    /**
     * @var string
     */
    private $_token_name = '_method';

    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct('form');
        $this->method( 'get' );
    }
    
    /**
     * @return string
     */
    public static function close()
    {
        return '</form>';
    }

    /**
     * @param string $method
     * @param string $token_name
     * @return $this
     */
    public function method( $method, $token_name = '_method' )
    {
        $method = strtolower($method);
        if (in_array($method, $this->http_methods)) {
            $this->_method = null;
            return $this->setAttribute( 'method', $method );
        }
        $this->_token_name = $token_name ?: $this->_token_name;
        $this->_method = $method;
        return $this;
    }

    /**
     * @param string $action
     * @return $this
     */
    public function action( $action )
    {
        return $this->setAttribute( 'action', $action );
    }

    /**
     * @return $this
     */
    public function uploader()
    {
        $this->method('post');
        return $this->setAttribute( 'enctype', 'multipart/form-data' );
    }

    /**
     * @return string
     */
    public function toString()
    {
        $html = TagToString::format($this);
        if(!is_null($this->_method)) {
            $html .= "\n<input type=\"hidden\" name=\"{$this->_token_name}\" value=\"". $this->_method ."\" />";
        }
        return $html;
    }
}