<?php
namespace tests\Tags;

use Tuum\Form\Tags\InputList;

require_once(__DIR__ . '/../autoloader.php');

class ListsTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        $input = (new InputList('radio', 'testing', ['more', 'done']));
        $this->assertEquals('Tuum\Form\Tags\InputList', get_class($input));
        $this->assertEquals('
<label ><input type="radio" name="testing" value="0" > more</label>
<label ><input type="radio" name="testing" value="1" > done</label>', (string)$input);
    }

    function test2()
    {
        $input = (new InputList('checkbox', 'testing', ['more', 'done']));
        $this->assertEquals('Tuum\Form\Tags\InputList', get_class($input));
        $this->assertEquals('
<label ><input type="checkbox" name="testing[]" value="0" > more</label>
<label ><input type="checkbox" name="testing[]" value="1" > done</label>', (string)$input);
    }
}