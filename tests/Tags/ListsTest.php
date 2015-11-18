<?php
namespace tests\Tags;

use Tuum\Form\Tags\InputList;

require_once(__DIR__ . '/../autoloader.php');

class ListsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function basic_radio_list()
    {
        $input = (new InputList('radio', 'testing', ['more', 'done']));
        $this->assertEquals('Tuum\Form\Tags\InputList', get_class($input));
        $this->assertEquals('<ul>
  <li><label><input type="radio" name="testing" value="0" > more</label></li>
  <li><label><input type="radio" name="testing" value="1" > done</label></li>
</ul>', (string)$input);
    }

    /**
     * @test
     */
    function radio_list_with_default_value()
    {
        $input = (new InputList('radio', 'testing', ['more', 'done'], '1' ));
        $this->assertEquals('Tuum\Form\Tags\InputList', get_class($input));
        $this->assertEquals('<ul>
  <li><label><input type="radio" name="testing" value="0" > more</label></li>
  <li><label><input type="radio" name="testing" value="1" checked > done</label></li>
</ul>', (string)$input);
    }

    /**
     * @test
     */
    function getInput_returns_raw_input_html()
    {
        $input = (new InputList('radio', 'testing', ['more', 'done']));
        $lists = $input->getList();
        $this->assertEquals('more', $lists[0]);
        $this->assertEquals('done', $lists[1]);
        $this->assertEquals('<input type="radio" name="testing" value="0" >', $input->getInput(0));
        $this->assertEquals('<input type="radio" name="testing" value="1" >', $input->getInput(1));
    }

    /**
     * @test
     */
    function getIterator_returns_list_of_tags()
    {
        $input = (new InputList('radio', 'testing', ['more', 'done']));
        foreach($input as $key => $item) {
            if ($key === 0) {
                $this->assertEquals('<input type="radio" name="testing" value="0" >', (string) $item);
                $this->assertEquals('more', $input->getLabel($key));
            } elseif ($key === 1) {
                $this->assertEquals('<input type="radio" name="testing" value="1" >', (string) $item);
                $this->assertEquals('done', $input->getLabel($key));
            }
        }
    }

    /**
     * @test
     */
    function basic_checkbox_list()
    {
        $input = (new InputList('checkbox', 'testing', ['more', 'done']));
        $this->assertEquals('Tuum\Form\Tags\InputList', get_class($input));
        $this->assertEquals('<ul>
  <li><label><input type="checkbox" name="testing[]" value="0" > more</label></li>
  <li><label><input type="checkbox" name="testing[]" value="1" > done</label></li>
</ul>', (string)$input);
    }

    /**
     * @test
     */
    function checkbox_list_with_defaults()
    {
        $input = (new InputList('checkbox', 'testing', ['more', 'done'], '0'));
        $this->assertEquals('Tuum\Form\Tags\InputList', get_class($input));
        $this->assertEquals('<ul>
  <li><label><input type="checkbox" name="testing[]" value="0" checked > more</label></li>
  <li><label><input type="checkbox" name="testing[]" value="1" > done</label></li>
</ul>', (string)$input);
    }

    /**
     * @test
     */
    function checkbox_list_with_defaults2()
    {
        $input = (new InputList('checkbox', 'testing', ['more', 'done'], ['0', '1']));
        $this->assertEquals('Tuum\Form\Tags\InputList', get_class($input));
        $this->assertEquals('<ul>
  <li><label><input type="checkbox" name="testing[]" value="0" checked > more</label></li>
  <li><label><input type="checkbox" name="testing[]" value="1" checked > done</label></li>
</ul>', (string)$input);
    }
}