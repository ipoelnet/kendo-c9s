<?php
use Kendo\DefinitionStorage;
use SimpleApp\SimpleDefinition;

class DefinitionStorageTest extends PHPUnit_Framework_TestCase
{
    public function testDefinitionStorage()
    {
        $loader = new DefinitionStorage;
        $loader->add(new SimpleDefinition);
    }
}

