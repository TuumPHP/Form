<?php
namespace tests\Form;

use Tuum\Form\Tags;

require_once(__DIR__ . '/../autoloader.php');

class TagTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $tags= new Tags('input');
        $this->assertEquals('Tuum\Form\Tags', get_class($tags));
        $this->assertEquals('<input  >', $tags->toString());
    }
}
