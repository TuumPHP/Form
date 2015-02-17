<?php
namespace tests\Form;

use Tuum\Form\Tags\Tag;

require_once(__DIR__ . '/../autoloader.php');

class TagTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $tags= new Tag('input');
        $this->assertEquals('Tuum\Form\Tags\Tag', get_class($tags));
        $this->assertEquals('<input >', (string) $tags);
    }

    /**
     * @test
     */
    function set_class_style()
    {
        $tags= (new Tag('test'))
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
        $tags = (new Tag('close'))
            ->closeTag()
            ->contents('tested')
            ->more('done')
            ;
        $this->assertEquals('<close more="done" >tested</close>', (string)$tags);
    }

    /**
     * @test
     */    
    function tag_replaces_value()
    {
        $tags = (new Tag('test'))
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
        $tags = (new Tag('test'))
            ->some('more')
            ->some('done', 'X')
        ;
        $this->assertEquals('<test some="moreXdone" >', (string)$tags);
    }
}
