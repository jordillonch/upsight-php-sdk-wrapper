<?php

namespace Akamon\Library\Upsight\Tests;

use Akamon\Library\Upsight\UpsightApi;
use PHPUnit_Framework_TestCase;

class UpsightApiTest extends PHPUnit_Framework_TestCase
{
    const API_KEY = 'some_api_key';

    /** @test */
    public function api_class_can_be_loaded()
    {
        $api = new UpsightApi(self::API_KEY, ['useTestServer' => true, 'validateParams' => true]);

        $this->assertEquals('Akamon\Library\Upsight\UpsightApi', get_class($api));
    }

    /** @test */
    public function send_track_event_in_debug_mode()
    {
        $api = new UpsightApi(self::API_KEY, ['debug' => true, 'validateParams' => true]);

        $this->sendAndAssert($api);
    }

    /** @test */
    public function send_track_event_to_prod_server()
    {
        $api = new UpsightApi(self::API_KEY, ['useTestServer' => false, 'validateParams' => true]);

        $this->sendAndAssert($api);
    }

    /** @test */
    public function send_track_event_to_test_server()
    {
        $api = new UpsightApi(self::API_KEY, ['useTestServer' => true, 'validateParams' => true]);

        $this->sendAndAssert($api);
    }

    private function sendAndAssert(UpsightApi $api)
    {
        $optionalParameters = [
            'value'    => 10,
            'subtype1' => 'abc',
            'subtype2' => 'def',
            'subtype3' => 'ghi',
            'data'     => '{a: 1}',
        ];
        $this->assertTrue($api->trackEvent(1234, 'foo', $optionalParameters));
    }
}
 