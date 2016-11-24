<?php

include(dirname(__FILE__) . '/../../vendor/autoload.php');
use Data;
class DataTest extends \PHPUnit_Framework_TestCase
{
    function testGet()
    {
        $data = new Data;
        $this->assertInternalType('array', $data->get('countries'));
    }
    function testGetWithFile()
    {
        $data = new Data;
        $this->assertFalse($data->get('missing'));
    }
}

?>