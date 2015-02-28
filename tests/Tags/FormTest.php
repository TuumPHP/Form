<?php
namespace tests\Tags;

use Tuum\Form\Tags\Form;

require_once(__DIR__ . '/../autoloader.php');

class FormTest extends \PHPUnit_Framework_TestCase
{
    function test0()
    {
        $form = new Form();
        $this->assertEquals('Tuum\Form\Tags\Form', get_class($form));
    }

    /**
     * @test
     */
    function form_create_opening_form()
    {
        $form = new Form();
        $form->action('test.php');
        $this->assertEquals('<form method="get" action="test.php" >', (string)$form);

        $form = new Form();
        $form->action('test.php')->method('get');
        $this->assertEquals('<form method="get" action="test.php" >', (string)$form);

        $form = new Form();
        $form->action('test.php')->method('post');
        $this->assertEquals('<form method="post" action="test.php" >', (string)$form);
    }

    /**
     * @test
     */
    function form_adds_hidden_tag_for_method_not_get_nor_post()
    {
        $form = new Form();
        $form->action('test.php')->method('put');
        $this->assertEquals(
            '<form method="get" action="test.php" >' . "\n". 
            '<input type="hidden" name="_method" value="put" />', 
            (string)$form);
    }

    /**
     * @test
     */
    function form_for_upload_sets_encType()
    {
        $form = new Form();
        $form->action('test.php')->uploader();
        $this->assertEquals(
            '<form method="post" action="test.php" enctype="multipart/form-data" >',
            (string)$form);
    }

    /**
     * @test
     */
    function form_for_upload_resets_method()
    {
        $form = new Form();
        $form->action('test.php')->method('bad')->uploader();
        $this->assertEquals(
            '<form method="post" action="test.php" enctype="multipart/form-data" >',
            (string)$form);
    }
}
