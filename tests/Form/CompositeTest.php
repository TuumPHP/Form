<?php
namespace tests\Form;

use Tuum\Form\Tags\Composite;

require_once(__DIR__ . '/../autoloader.php');

class CompositeTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $input = new Composite('test', [], '');
        $this->assertEquals('Tuum\Form\Tags\Composite', get_class($input));
    }
}
