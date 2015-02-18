<?php
namespace tests\Form;

use Tuum\Form\Date;

require_once(__DIR__ . '/../autoloader.php');

class DateTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $form = new Date();
        $this->assertEquals('Tuum\Form\Date', get_class($form));
    }
}
