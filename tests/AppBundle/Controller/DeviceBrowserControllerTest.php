<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 15.03.2016
 * Time: 8:30
 */

namespace tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeviceBrowserControllerTest extends WebTestCase
{
    protected $client;
    protected $deviceId = 1;
    protected $browserVersionId = 8;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    public function testAddDeviceBrowser()
    {
        $this->client->request('POST', '/api/v1/devicebrowsers.json',[
            'device_browser' => [
                'device' => $this->deviceId
                ,'browserversion' => $this->browserVersionId
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());

        $location = $response->headers->get('Location');

        $this->assertNotEmpty($location, 'Empty Location header');

        return $location;
    }

    public function testAddTheSameNameDeviceBrowser()
    {
        $this->client->request('POST', '/api/v1/devicebrowsers.json',[
            'device_browser' => [
                'device' => $this->deviceId
                ,'browserversion' => $this->browserVersionId
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(500, $response->getStatusCode(), $response->getContent());

        $location = $response->headers->get('Location');
        $this->assertEmpty($location, 'Empty Location header');

    }

    /**
     * @depends testAddDeviceBrowser
     */
    public function testGetDeviceBrowser($link)
    {
        $this->client->request('GET', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDeviceBrowser
     */
    public function testEditDeviceBrowser($link)
    {

        $this->client->request('PATCH', $link.'/modify.json',[
            'device_browser' => [
                'device' => $this->deviceId
                ,'browserversion' => $this->browserVersionId
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDeviceBrowser
     */
    public function testGetDeviceBrowsersList()
    {
        $this->client->request('GET', '/api/v1/devicebrowsers/all.json');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());

        $json = json_decode($response->getContent());

        $this->assertTrue(count($json) > 0, $response->getContent());

    }

    /**
     * @depends testAddDeviceBrowser
     */
    public function testRemoveDeviceBrowser($link)
    {
        $this->client->request('DELETE', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDeviceBrowser
     */
    public function testRemoveDeviceBrowserNotFound($link)
    {
        $this->client->request('DELETE', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDeviceBrowser
     */
    public function testEditDeviceBrowserNotFound($link)
    {
        $this->client->request('PATCH', $link.'/modify.json',[
            'device_browser' => [
                'device' => $this->deviceId
                ,'browserversion' => $this->browserVersionId
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDeviceBrowser
     */
    public function testGetDeviceBrowserNotFound($link)
    {
        $this->client->request('GET', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }


}
