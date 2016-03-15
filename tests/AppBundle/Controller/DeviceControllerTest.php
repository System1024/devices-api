<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 15.03.2016
 * Time: 8:30
 */

namespace tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeviceControllerTest extends WebTestCase
{
    protected $client;
    protected $deviceTypeId = 1;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    public function testAddDevice()
    {
        $this->client->request('POST', '/api/v1/devices.json',[
            'device' => [
                'name' => 'TestDevice'
                ,'description' => 'Test Description'
                ,'devicetype' => $this->deviceTypeId
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());

        $location = $response->headers->get('Location');

        $this->assertNotEmpty($location, 'Empty Location header');

        return $location;
    }

    public function testAddTheSameNameDevice()
    {
        $this->client->request('POST', '/api/v1/devices.json',[
            'device' => [
                'name' => 'TestDevice'
                ,'description' => 'Test Description'
                ,'devicetype' => $this->deviceTypeId
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(500, $response->getStatusCode(), $response->getContent());

        $location = $response->headers->get('Location');
        $this->assertEmpty($location, 'Empty Location header');

    }

    /**
     * @depends testAddDevice
     */
    public function testGetDevice($link)
    {
        $this->client->request('GET', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDevice
     */
    public function testEditDevice($link)
    {

        $this->client->request('PATCH', $link.'/modify.json',[
            'device' => [
                'name' => 'TestDevice-Edited'
                ,'description' => 'Test Description'
                ,'devicetype' => $this->deviceTypeId
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDevice
     */
    public function testGetDevicesList()
    {
        $this->client->request('GET', '/api/v1/devices/all.json');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());

        $json = json_decode($response->getContent());

        $this->assertTrue(count($json) > 0, $response->getContent());

    }

    /**
     * @depends testAddDevice
     */
    public function testRemoveDevice($link)
    {
        $this->client->request('DELETE', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDevice
     */
    public function testRemoveDeviceNotFound($link)
    {
        $this->client->request('DELETE', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDevice
     */
    public function testEditDeviceNotFound($link)
    {
        $this->client->request('PATCH', $link.'/modify.json',[
            'device' => [
                'name' => 'TestDevice-Edited'
                ,'description' => 'Test Description'
                ,'devicetype' => $this->deviceTypeId
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDevice
     */
    public function testGetDeviceNotFound($link)
    {
        $this->client->request('GET', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }


}
