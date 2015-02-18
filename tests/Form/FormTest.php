<?php
namespace tests\Form;

use Tuum\Form\Form;

require_once(__DIR__ . '/../autoloader.php');

class FormTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $form = new Form();
        $this->assertEquals('Tuum\Form\Form', get_class($form));
    }

    /**
     * @test
     */
    function returns_input_object()
    {
        $form = new Form();
        $input = $form->text('test', 'testing');
        $this->assertEquals('Tuum\Form\Tags\Input', get_class($input));
        $this->assertEquals( 'test', $input->getName());
        $this->assertEquals( 'testing', $input->get('value'));
    }
}
