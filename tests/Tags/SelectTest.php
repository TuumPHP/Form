<?php
namespace tests\Tags;

use Tuum\Form\Tags\Select;

require_once(__DIR__ . '/../autoloader.php');

class SelectTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $input = (new Select('select', 'testing', ['more', 'done']));
        $this->assertEquals('Tuum\Form\Tags\Select', get_class($input));
        $this->assertEquals('<select name="testing" >
  <option value="0">more</option>
  <option value="1">done</option>
</select>', (string)$input);
    }
}