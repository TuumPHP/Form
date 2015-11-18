<?php
namespace tests\Form;

use Tuum\Form\Data\Data;

require_once(__DIR__ . '/../autoloader.php');

class Entity
{
    private $value = 'my value';

    public function getEntityValue()
    {
        return $this->value;
    }
}

class DateWithEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function data_access_value_using_getter()
    {
        $entity = new Entity;
        $data   = new Data($entity);
        $this->assertEquals('', $data->no_such);
        $this->assertEquals('', $data->value);
        $this->assertEquals('my value', $data->entity_value);
        $this->assertEquals('my value', $data->entityValue);
        $this->assertEquals('my value', $data->entityvalue);
    }
}
