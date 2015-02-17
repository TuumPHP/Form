<?php
namespace tests\Tags;

use Tuum\Form\Tags\Lists;

require_once(__DIR__ . '/../autoloader.php');

class ListsTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $input = (new Lists('select', 'testing', ['more', 'done']));
        $this->assertEquals('Tuum\Form\Tags\Lists', get_class($input));
        $this->assertEquals('<input type="text" name="testing" >', (string)$input);
    }
}