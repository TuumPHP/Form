<?php
namespace tests\Form;

use Tuum\Form\Data\Data;
use Tuum\Form\Data\Errors;
use Tuum\Form\Data\Escape;
use Tuum\Form\Data\Inputs;
use Tuum\Form\Data\Message;
use Tuum\Form\DataView;

class DataViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function constructs_with_escape_sets_properties()
    {
        $view = new DataView(new Escape());
        $this->assertEquals('Tuum\Form\DataView', get_class($view));
        $this->assertEquals('Tuum\Form\Dates', get_class($view->dates));
        $this->assertEquals('Tuum\Form\Forms', get_class($view->forms));
    }

    /**
     * @test
     */
    function set_various_stuff()
    {
        $view = new DataView(new Escape());
        $view->setData([]);
        $view->setErrors([]);
        $view->setInputs([]);
        $view->setMessage([]);

        $this->assertEquals('Tuum\Form\Data\Data', get_class($view->data));
        $this->assertEquals('Tuum\Form\Data\Errors', get_class($view->errors));
        $this->assertEquals('Tuum\Form\Data\Inputs', get_class($view->inputs));
        $this->assertEquals('Tuum\Form\Data\Message', get_class($view->message));
    }

    /**
     * @test
     */
    function sets_escape_callable()
    {
        $view = new DataView(function ($input) {
            if (is_string($input)) {
                return 'esc:' . $input;
            }
            return $input;
        });
        $data = ['test' => 'tested'];
        $view->setData($data);
        $view->setErrors($data);
        $view->setInputs($data);
        $view->setMessage($data);

        $this->assertEquals('esc:tested', $view->data->get('test'));
        $this->assertEquals('esc:tested', $view->inputs->get('test'));
    }

    /**
     * @test
     */
    function set_objects()
    {
        $view    = new DataView(new Escape());
        $data    = new Data([]);
        $errors  = Errors::forge([]);
        $inputs  = Inputs::forge([]);
        $message = Message::forge([]);

        $view->setData($data);
        $view->setErrors($errors);
        $view->setInputs($inputs);
        $view->setMessage($message);

        $this->assertSame($data, $view->data);
        $this->assertSame($errors, $view->errors);
        $this->assertSame($inputs, $view->inputs);
        $this->assertSame($message, $view->message);
    }

}
