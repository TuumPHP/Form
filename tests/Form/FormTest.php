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

    /**
     * @test
     */
    function radio()
    {
        $form = new Forms();
        $radio = $form->radio('test', 'tested');
        $this->assertEquals('radio', $radio->getAttribute()['type']);
        $this->assertEquals('test', $radio->getAttribute()['name']);
        $this->assertEquals('tested', $radio->getAttribute()['value']);
    }

    /**
     * @test
     */
    function checkbox()
    {
        $form = new Forms();
        $radio = $form->checkbox('test', 'tested');
        $this->assertEquals('checkbox', $radio->getAttribute()['type']);
        $this->assertEquals('test', $radio->getAttribute()['name']);
        $this->assertEquals('tested', $radio->getAttribute()['value']);
    }

    /**
     * @test
     */    
    function label()
    {
        $form = new Forms();
        $radio = $form->label('test', 'tested');
        $this->assertEquals('test', $radio->getContents());
        $this->assertEquals('tested', $radio->getAttribute()['for']);
    }

    /**
     * @test
     */
    function buttons()
    {
        $form = new Forms();
        $submit = $form->submit('test');
        $this->assertEquals('submit', $submit->getAttribute()['type']);
        $this->assertEquals('test', $submit->getAttribute()['value']);
        $submit = $form->reset('test');
        $this->assertEquals('reset', $submit->getAttribute()['type']);
        $this->assertEquals('test', $submit->getAttribute()['value']);
    }

    /**
     * @test
     */
    function textarea()
    {
        $form = new Forms();
        $area = $form->textArea('test', 'tested');
        $this->assertEquals('tested', $area->getContents());
        $this->assertEquals('textarea', $area->getTagName());
        $this->assertEquals('test', $area->getAttribute()['name']);
    }

    /**
     * @test
     */
    function select()
    {
        $form = new Forms();
        $list = ['t' => 'tested', 'm' => 'more'];
        $select = $form->select('test', $list);
        $this->assertEquals('select', $select->getTagName());
        $this->assertEquals($list, $select->getList());
    }

    /**
     * @test
     */
    function checkList()
    {
        $form = new Forms();
        $list = ['t' => 'tested', 'm' => 'more'];
        $checks = $form->checkList('test', $list, 'm');
        $this->assertEquals('input', $checks->getTagName());
        $this->assertEquals($list, $checks->getList());
        
        $input = $checks->getInput('t');
        $this->assertEquals('input', $input->getTagName());
        $this->assertEquals('checkbox', $input->getAttribute()['type']);
        $this->assertEquals('test[]', $input->getAttribute()['name']);
        $this->assertEquals('t', $input->getAttribute()['value']);

        $input = $checks->getInput('m');
        $this->assertEquals('input', $input->getTagName());
        $this->assertEquals('checkbox', $input->getAttribute()['type']);
        $this->assertEquals('test[]', $input->getAttribute()['name']);
        $this->assertEquals('m', $input->getAttribute()['value']);
    }

    /**
     * @test
     */
    function radioList()
    {
        $form = new Forms();
        $list = ['t' => 'tested', 'm' => 'more'];
        $checks = $form->radioList('test', $list, 'm');
        $this->assertEquals('input', $checks->getTagName());
        $this->assertEquals($list, $checks->getList());
        
        $input = $checks->getInput('t');
        $this->assertEquals('input', $input->getTagName());
        $this->assertEquals('radio', $input->getAttribute()['type']);
        $this->assertEquals('test', $input->getAttribute()['name']);
        $this->assertEquals('t', $input->getAttribute()['value']);

        $input = $checks->getInput('m');
        $this->assertEquals('input', $input->getTagName());
        $this->assertEquals('radio', $input->getAttribute()['type']);
        $this->assertEquals('test', $input->getAttribute()['name']);
        $this->assertEquals('m', $input->getAttribute()['value']);
    }

    /**
     * @test
     * 
     */
    function withClass_sets_class_to_elements()
    {
        $form = new Forms();
        $class = 'tested-withClass';
        $form = $form->withClass($class);
        
        $this->assertEquals($class, $form->text('test')->getAttribute()['class']);
        $this->assertEquals($class, $form->checkbox('t', 'test')->getAttribute()['class']);
        $this->assertEquals($class, $form->select('test', ['test'])->getAttribute()['class']);
    }

    /**
     * @test
     */
    function withClass_not_working_for_InputList()
    {
        $form = new Forms();
        $class = 'tested-withClass';
        $form = $form->withClass($class);

        $attributes = $form->radioList('test', ['t' => 'test'])
            ->getInput('t')
            ->getAttribute();

        $this->markTestIncomplete(
            'This feature has not been implemented yet.'
        );

        $this->assertEquals(
            $class,
            isset($attributes['class'])?$attributes['class']: null
        );
    }

    /**
     * @test
     */
    function formGroup()
    {
        $form = new Forms();
        $group = $form->formGroup('test', 'more');
        $this->assertEquals('div', $group->getTagName());
        $this->assertContains('test', $group->getContents());
        $this->assertContains('more', $group->getContents());
    }
}
