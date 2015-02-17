<?php
namespace tests\Form;

use Tuum\Form\Tags;

require_once(__DIR__ . '/../autoloader.php');

class TagTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $tags= new Tags('input');
        $this->assertEquals('Tuum\Form\Tags', get_class($tags));
        $this->assertEquals('<input  >', (string) $tags);
    }

    /**
     * @test
     */
    function set_class_style()
    {
        $tags= (new Tags('test'))
            ->class('testing')
            ->style('styled')
            ->class('testing2')
            ->style('styled2')
        ;
        $this->assertEquals('<test class="testing testing2" style="styled; styled2" >', $tags->toString());
    }

    /**
     * @test
     */
    function use_closed_returns()
    {
        $tags = (new Tags('close'))
            ->closeTag()
            ->contents('tested')
            ->more('done')
            ;
        $this->assertEquals('<close more="done" >tested</close>', (string)$tags);
    }

    /**
     * @test
     */
    function label_wraps_tag()
    {
        $tags = (new Tags('info'))
            ->class('testing')
            ->label('important')
        ;
        $this->assertEquals('<label><info class="testing" > important</label>', (string)$tags);
    }

    /**
     * @test
     */    
    function tag_replaces_value()
    {
        $tags = (new Tags('test'))
            ->some('more')
            ->some('done')
        ;
        $this->assertEquals('<test some="done" >', (string)$tags);
    }

    /**
     * @test
     */
    function tag_with_sep_adds_value()
    {
        $tags = (new Tags('test'))
            ->some('more')
            ->some('done', 'X')
        ;
        $this->assertEquals('<test some="moreXdone" >', (string)$tags);
    }
}
