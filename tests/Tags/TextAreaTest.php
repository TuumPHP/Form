<?php
namespace tests\Form;

use Tuum\Form\Tags\TextArea;

require_once(__DIR__ . '/../autoloader.php');

class TextAreaTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $ta = new TextArea('test');
        $this->assertEquals('Tuum\Form\Tags\TextArea', get_class($ta));
        $this->assertEquals('<textarea name="test" ></textarea>', (string)$ta);
    }
}
