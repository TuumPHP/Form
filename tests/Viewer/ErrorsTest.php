<?php
namespace tests\Viewer;

use Tuum\Form\Data\Errors;

require_once(dirname(__DIR__) . '/autoloader.php');

class ErrorsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function get_formatted_and_raw_errors()
    {
        $errors = Errors::forge(['test' => 'tested']);
        $this->assertTrue($errors->exists('test'));
        $this->assertFalse($errors->exists('no-such'));
        $this->assertEquals('tested', $errors->raw('test'));
        $this->assertEquals('<p class="text-danger">tested</p>', $errors->p('test'));
        $this->assertEquals(null, $errors->raw('none'));
    }
}
