<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 15.03.2016
 * Time: 8:30
 */

namespace tests\AppBundle\Controller;


//use FOS\RestBundle\Tests\Functional\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BrowserControllerTest extends WebTestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client   = static::createClient();
    }
    public function testGetBrowsersList()
    {
        $this->client->request('GET', '/api/v1/browsers/all.json');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());

        $json = json_decode($response->getContent());

        return $json;
    }

    public function testAddBrowser()
    {
        $this->client->request('POST', '/api/v1/browsers.json',[
            'browser' => [
                'name' => 'TestBrowser'
            ]
        ]);

        $response = $this->client->getResponse();

        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());
    }


    /**
     * @depends testGetBrowsersList
     */
//    public function testGetBrowsers($json)
//    {
//        if (count($json)>0) {
//            $this->client->request('GET', '/api/v1/browsers/all.json');
//            $response = $this->client->getResponse();
//            $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
//        }
//    }

}
