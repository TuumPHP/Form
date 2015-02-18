<?php
namespace tests\Form;

use Tuum\Form\Date;
use Tuum\Form\Tags\Composite;

require_once(__DIR__ . '/../autoloader.php');

class CompositeTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $input = new Composite([], 'test');
        $this->assertEquals('Tuum\Form\Tags\Composite', get_class($input));
    }

    /**
     * @test
     */
    function dateYM_returns_composite()
    {
        $form = new Date();
        $date = $form->dateYM('test');
        $this->assertEquals('Tuum\Form\Tags\Composite', get_class($date));
        $this->assertEquals('<select name="test_y" >
  <option value="2014">2014</option>
  <option value="2015">2015</option>
  <option value="2016">2016</option>
</select>, <select name="test_m" >
  <option value="1">01</option>
  <option value="2">02</option>
  <option value="3">03</option>
  <option value="4">04</option>
  <option value="5">05</option>
  <option value="6">06</option>
  <option value="7">07</option>
  <option value="8">08</option>
  <option value="9">09</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
</select>', (string)$date);
    }
}
