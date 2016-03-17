<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 15.03.2016
 * Time: 8:30
 */

namespace tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DevicetypeControllerTest extends WebTestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client   = static::createClient();
    }

    public function testAddDevicetype()
    {
        $this->client->request('POST', '/api/v1/devicetypes.json',[
            'devicetypes' => [
                'name' => 'TestDevicetype',
                'description' => 'Test description'
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());

        $location = $response->headers->get('Location');

        $this->assertNotEmpty($location, 'Empty Location header');

        return $location;
    }

    public function testAddTheSameNameDevicetype()
    {
        $this->client->request('POST', '/api/v1/devicetypes.json',[
            'devicetypes' => [
                'name' => 'TestDevicetype',
                'description' => 'Test description'
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(500, $response->getStatusCode(), $response->getContent());

        $location = $response->headers->get('Location');
        $this->assertEmpty($location, 'Empty Location header');

    }

    /**
     * @depends testAddDevicetype
     */
    public function testGetDevicetype($link)
    {
        $this->client->request('GET', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDevicetype
     */
    public function testEditDevicetype($link)
    {

        $this->client->request('PATCH', $link.'/modify.json',[
            'devicetypes' => [
                'name' => 'TestDevicetype-Edited',
                'description' => 'Test description'
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDevicetype
     */
    public function testGetDevicetypesList()
    {
        $this->client->request('GET', '/api/v1/devicetypes/all.json');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());

        $json = json_decode($response->getContent());

        $this->assertTrue(count($json) > 0, $response->getContent());

    }

    /**
     * @depends testAddDevicetype
     */
    public function testRemoveDevicetype($link)
    {
        $this->client->request('DELETE', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDevicetype
     */
    public function testRemoveDevicetypeNotFound($link)
    {
        $this->client->request('DELETE', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDevicetype
     */
    public function testEditDevicetypeNotFound($link)
    {
        $this->client->request('PATCH', $link.'/modify.json',[
            'devicetypes' => [
                'name' => 'TestDevicetype-Edited',
                'description' => 'Test description'
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddDevicetype
     */
    public function testGetDevicetypeNotFound($link)
    {
        $this->client->request('GET', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }


}
