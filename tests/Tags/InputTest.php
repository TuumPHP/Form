<?php
namespace tests\Form;

use Tuum\Form\Tags\Input;

require_once(__DIR__ . '/../autoloader.php');

class InputTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $input = (new Input('text', 'testing'));
        $this->assertEquals('Tuum\Form\Tags\Input', get_class($input));
        $this->assertEquals('<input type="text" name="testing" >', (string)$input);
    }

    /**
     * @test
     */
    function label_surrounds_input()
    {
        $input = (new Input('text', 'testing'))
            ->value('more')
            ->maxlength(5)
            ->label('done')
            ->imeOn();
        $this->assertEquals(
            '<label><input type="text" name="testing" value="more" maxlength="5" style="ime-mode:active" > done</label>',
            (string)$input);
    }

    /**
     * @test
     */
    function input_has_more_methods()
    {
        $input = (new Input('text', 'testing'))
            ->imeOff()
            ->width('5em')
            ->height('10em');
        $this->assertEquals(
            '<input type="text" name="testing" style="ime-mode:inactive; width:5em; height:10em" >',
            (string)$input);
    }

    /**
     * @test
     */
    function set_multiple_adds_double_bracket_to_name()
    {
        $input = (new Input('text', 'testing'));
        $this->assertEquals('testing', $input->getName());
        $input->setMultiple();
        $this->assertEquals('testing[]', $input->getName());
    }

    /**
     * @test
     */
    function name_is_used_if_id_is_not_set()
    {
        $input = (new Input('text', 'testing'));
        $this->assertEquals('testing', $input->getId());
    }

    /**
     * @test
     */
    function id_is_used_if_id_is_set()
    {
        $input = (new Input('text', 'testing'))->id('real-id');
        $this->assertEquals('real-id', $input->getId());
    }

    /**
     * @test
     */
    function id_adds_value_to_id_for_radio_and_checks_if_id_is_not_set()
    {
        $input = (new Input('radio', 'testing'))->value('more');
        $this->assertEquals('testing-more', $input->getId());
        $input->setMultiple();
        $this->assertEquals('testing---more', $input->id()->getId());
    }

}
