<?php

namespace Akamon\Library\Upsight\Tests;

use Akamon\Library\Upsight\UpsightApi;

class UpsightApiTest extends \PHPUnit_Framework_TestCase
{
    public function test_api_class_can_be_loaded()
    {
        $api = new UpsightApi('some_api_key', ['useTestServer' => true, 'validateParams' => true]);

        $this->assertEquals('Akamon\Library\Upsight\UpsightApi', get_class($api));
    }
}
 