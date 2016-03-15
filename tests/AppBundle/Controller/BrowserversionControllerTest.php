<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 15.03.2016
 * Time: 8:30
 */

namespace tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BrowserversionControllerTest extends WebTestCase
{
    protected $client;
    protected $browserId = false;

    protected function setUp()
    {
        $this->client   = static::createClient();
    }

    protected function getBrowser() {
        $this->client->request('GET', '/api/v1/browsers/all.json');
        $response = $this->client->getResponse();

        $json = json_decode($response->getContent());

        if (empty($json)) {
            throw new \Exception('You should add browser first');
        }

        $this->browserId = $json[0]->id;

        return $this->browserId;
    }

    public function testAddBrowserversion()
    {
        $this->client->request('POST', '/api/v1/browserversions.json',[
            'browserversion' => [
                'version' => 'TestBrowserversion',
                'browser' => $this->getBrowser()
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());

        $location = $response->headers->get('Location');

        $this->assertNotEmpty($location, 'Empty Location header');

        return $location;
    }

    public function testAddTheSameNameBrowserversion()
    {
        $this->client->request('POST', '/api/v1/browserversions.json',[
            'browserversion' => [
                'version' => 'TestBrowserversion',
                'browser' => $this->getBrowser()
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(500, $response->getStatusCode(), $response->getContent());

        $location = $response->headers->get('Location');
        $this->assertEmpty($location, 'Empty Location header');

    }

    /**
     * @depends testAddBrowserversion
     */
    public function testGetBrowserversion($link)
    {
        $this->client->request('GET', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddBrowserversion
     */
    public function testEditBrowserversion($link)
    {

        $this->client->request('PATCH', $link.'/modify.json',[
            'browserversion' => [
                'name' => 'TestBrowserversion-Edited'
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddBrowserversion
     */
    public function testGetBrowserversionsList()
    {
        $this->client->request('GET', '/api/v1/browserversions/all.json');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());

        $json = json_decode($response->getContent());

        $this->assertTrue(count($json) > 0, $response->getContent());

    }

    /**
     * @depends testAddBrowserversion
     */
    public function testRemoveBrowserversion($link)
    {
        $this->client->request('DELETE', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddBrowserversion
     */
    public function testRemoveBrowserversionNotFound($link)
    {
        $this->client->request('DELETE', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddBrowserversion
     */
    public function testEditBrowserversionNotFound($link)
    {
        $this->client->request('PATCH', $link.'/modify.json',[
            'browserversion' => [
                'name' => 'TestBrowserversion-Edited'
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddBrowserversion
     */
    public function testGetBrowserversionNotFound($link)
    {
        $this->client->request('GET', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }


}
