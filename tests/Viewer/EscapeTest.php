<?php
namespace tests\Viewer;

use Tuum\Form\Data\Escape;

require_once(dirname(__DIR__) . '/autoloader.php');

class EscapeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function safe_escapes_and_htmlSafe_as_default()
    {
        $view = new Escape();
        $this->assertEquals('&lt;bold&gt;', $view->escape('<bold>'));
        $this->assertEquals('a&#039;b', $view->escape('a\'b'));

        // change escape functions
        $view->setEscape('addslashes');
        $this->assertEquals('<bold>', $view->escape('<bold>'));
        $this->assertEquals('a\\\'b', $view->escape('a\'b'));
    }

    /**
     * @test
     */
    function use_addSlash_as_default()
    {
        $escape = new Escape('addslashes');

        $this->assertEquals('a\\\'b', $escape('a\'b'));

        $add = $escape->getEscape();
        $this->assertEquals('a\\\'b', $add('a\'b'));
    }
}
