<?php
namespace tests\Form;

use Tuum\Form\Dates;
use Tuum\Form\Format\YearList;

require_once(__DIR__ . '/../autoloader.php');

class DateTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $form = new Dates();
        $this->assertEquals('Tuum\Form\Dates', get_class($form));
    }

    /**
     * @test
     */
    function dateYM_returns_composite()
    {
        $form = new Dates();
        $date = $form->dateYM('test');
        $this->assertEquals('Tuum\Form\Tags\Composite', get_class($date));
        $this->assertEquals('<select name="test_y" >
  <option value="2014">2014</option>
  <option value="2015">2015</option>
  <option value="2016">2016</option>
</select>/<select name="test_m" >
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

    /**
     * @test
     */
    function dateYM_with_format_string()
    {
        $form = new Dates();
        $date = $form->dateYM('test')->format('Year %s Month %s');
        $this->assertEquals('Tuum\Form\Tags\Composite', get_class($date));
        $this->assertEquals('Year <select name="test_y" >
  <option value="2014">2014</option>
  <option value="2015">2015</option>
  <option value="2016">2016</option>
</select> Month <select name="test_m" >
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

    /**
     * @test
     */
    function dateYM_with_format_closure()
    {
        $form = new Dates();
        $date = $form->dateYM('test')->format(function($fields) {
            return implode('formatted', $fields);
        });
        $this->assertEquals('Tuum\Form\Tags\Composite', get_class($date));
        $this->assertEquals('<select name="test_y" >
  <option value="2014">2014</option>
  <option value="2015">2015</option>
  <option value="2016">2016</option>
</select>formatted<select name="test_m" >
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

    /**
     * @test
     */
    function dateYM_and_head_adds_extra_option()
    {
        $form = new Dates();
        $date = $form->dateYM('test')->head('testing');
        $this->assertEquals('Tuum\Form\Tags\Composite', get_class($date));
        $this->assertEquals('<select name="test_y" >
  <option value="" selected>testing</option>
  <option value="2014">2014</option>
  <option value="2015">2015</option>
  <option value="2016">2016</option>
</select>/<select name="test_m" >
  <option value="" selected>testing</option>
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

    /**
     * @test
     */
    function dateYM_returns_nenGou()
    {
        $form = new Dates();
        
        $date = $form->dateYM('test');
        /** @noinspection PhpUndefinedMethodInspection */
        $date->y->getList()->setFormat(YearList::formatJpnGenGou());
        $this->assertEquals('<select name="test_y" >
  <option value="2014">平成26年</option>
  <option value="2015">平成27年</option>
  <option value="2016">平成28年</option>
</select>/<select name="test_m" >
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

    /**
     * @test
     */
    function timeHi_returns_composite()
    {
        $form = new Dates();
        $date = $form->timeHi('test', '08:25');
        $this->assertEquals('Tuum\Form\Tags\Composite', get_class($date));
        $this->assertEquals('<select name="test_h" >
  <option value="0">00</option>
  <option value="1">01</option>
  <option value="2">02</option>
  <option value="3">03</option>
  <option value="4">04</option>
  <option value="5">05</option>
  <option value="6">06</option>
  <option value="7">07</option>
  <option value="8" selected>08</option>
  <option value="9">09</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
</select>:<select name="test_i" >
  <option value="0">00</option>
  <option value="5">05</option>
  <option value="10">10</option>
  <option value="15">15</option>
  <option value="20">20</option>
  <option value="25" selected>25</option>
  <option value="30">30</option>
  <option value="35">35</option>
  <option value="40">40</option>
  <option value="45">45</option>
  <option value="50">50</option>
  <option value="55">55</option>
</select>', (string)$date);
    }
}
