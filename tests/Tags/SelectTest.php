<?php
namespace tests\Tags;

use Tuum\Form\Tags\Select;

require_once(__DIR__ . '/../autoloader.php');

class SelectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function basic_select_test()
    {
        $input = (new Select('select', 'testing', ['more', 'done']));
        $this->assertEquals('Tuum\Form\Tags\Select', get_class($input));
        $this->assertEquals('<select name="testing" >
  <option value="0">more</option>
  <option value="1">done</option>
</select>', (string)$input);
    }

    /**
     * @test
     */
    function select_test_with_default()
    {
        $input = (new Select('select', 'testing', ['more', 'done'], '1'));
        $this->assertEquals('<select name="testing" >
  <option value="0">more</option>
  <option value="1" selected>done</option>
</select>', (string)$input);
    }

    /**
     * @test
     */
    function select_test_with_multiple()
    {
        $input = (new Select('select', 'testing', ['more', 'done'], '1'))->setMultiple();
        $this->assertEquals('<select name="testing[]" >
  <option value="0">more</option>
  <option value="1" selected>done</option>
</select>', (string)$input);
    }

    /**
     * @test
     */
    function select_test_with_multiple_and_default()
    {
        $input = (new Select('select', 'testing', ['some', 'more', 'done'], ['0', '2']))->setMultiple();
        $this->assertEquals('<select name="testing[]" >
  <option value="0" selected>some</option>
  <option value="1">more</option>
  <option value="2" selected>done</option>
</select>', (string)$input);
    }
}