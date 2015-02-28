<?php
namespace tests\Form;

use Tuum\Form\Forms;

require_once(__DIR__ . '/../autoloader.php');

class FormTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $form = new Forms();
        $this->assertEquals('Tuum\Form\Forms', get_class($form));
    }

    /**
     * @test
     */
    function returns_input_object()
    {
        $form = new Forms();
        $input = $form->text('test', 'testing');
        $this->assertEquals('Tuum\Form\Tags\Input', get_class($input));
        $this->assertEquals( 'test', $input->getName());
        $this->assertEquals( 'testing', $input->get('value'));
    }

    /**
     * @test
     */
    function form_builds_various_input_object()
    {
        $form = new Forms();
        $input = $form->hidden('test', 'testing');
        $this->assertEquals('<input type="hidden" name="test" value="testing" >', (string) $input);
    }

    /**
     * @test
     */
    function textArea_returns_TextArea_object()
    {
        $form = new Forms();
        $input = $form->textArea('test', 'testing');
        $this->assertEquals('Tuum\Form\Tags\TextArea', get_class($input));
        $this->assertEquals('<textarea name="test" >testing</textarea>', (string) $input);
    }

    /**
     * @test
     */
    function open_returns_Form_object()
    {
        $form = new Forms();
        $input = $form->open();
        $this->assertEquals('Tuum\Form\Tags\Form', get_class($input));
        $this->assertEquals('<form method="get" >', (string) $input);
    }

    /**
     * @test
     */
    function close_returns_Form_object()
    {
        $form = new Forms();
        $input = $form->close();
        $this->assertEquals('</form>', $input);
    }
}
