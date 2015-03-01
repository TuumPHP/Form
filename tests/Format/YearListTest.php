<?php
namespace tests\Format;

use Tuum\Form\Lists\Lists;
use Tuum\Form\Lists\YearList;

require_once(__DIR__ . '/../autoloader.php');

class FormTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $form = YearList::forge();
        $this->assertEquals('Tuum\Form\Lists\YearList', get_class($form));
    }

    /**
     * @test
     */
    function japanese_年号()
    {
        $form = YearList::forge();
        $form->setFormat(YearList::formatJpnGenGou());
        $format = $form->getFormat();
        
        // beginning of Nengou
        $this->assertEquals('西暦1868年', $format('1868'));
        $this->assertEquals('明治元年', $format('1869'));
        $this->assertEquals('明治2年', $format('1870'));
        
        // heisei
        $this->assertEquals('昭和63年', $format('1988'));
        $this->assertEquals('平成元年', $format('1989'));
        $this->assertEquals('平成2年', $format('1990'));
        $this->assertEquals('平成32年', $format('2020'));
        $this->assertEquals('平成2012年', $format('4000'));
        $this->assertEquals('西暦10000年', $format('10000'));
    }

    /**
     * @test
     */
    function reverse_lists()
    {
        $list = Lists::forge(10, 4, -3)->setFormat(function($s) {return "<$s>";});
        foreach($list as $val => $label) {
            switch($val) {
                case 10:
                    $this->assertEquals('<10>', $label);
                    break;
                case 7:
                    $this->assertEquals('<7>', $label);
                    break;
                case 4:
                    $this->assertEquals('<4>', $label);
                    break;
                default:
                    $this->assertTrue(false);
            }
        }
    }
}
