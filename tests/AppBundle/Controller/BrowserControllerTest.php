<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 15.03.2016
 * Time: 8:30
 */

namespace tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BrowserControllerTest extends WebTestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client   = static::createClient();
    }

//    public function testRest()
//    {
//        // create entity manager mock
//        $entityManagerMock = $this->getMockBuilder('Doctrine\ORM\EntityManager')
//            ->setMethods(array('persist', 'flush'))
//            ->disableOriginalConstructor()
//            ->getMock();
//
//        // now you can get some assertions if you want, eg.:
//        $entityManagerMock->expects($this->once())
//            ->method('flush');
//
//        // next you need inject your mocked em into client's service container
//        $client = static::createClient();
//        $client->getContainer()->set('doctrine.orm.default_entity_manager', $entityManagerMock);
//
//        // then you just do testing as usual
//        $crawler = $client->request('POST', '/service/sandbox', array(), array(), array(), json_encode(array('name' => 'TestMe', 'description' => 'TestDesc')));
//
//        $this->assertEquals(
//            201, $client->getResponse()->getStatusCode()
//        );
//    }

    public function testAddBrowser()
    {
        $this->client->request('POST', '/api/v1/browsers.json',[
            'browser' => [
                'name' => 'TestBrowser'
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());

        $location = $response->headers->get('Location');

        $this->assertNotEmpty($location, 'Empty Location header');

        return $location;
    }

    public function testAddTheSameNameBrowser()
    {
        $this->client->request('POST', '/api/v1/browsers.json',[
            'browser' => [
                'name' => 'TestBrowser'
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(500, $response->getStatusCode(), $response->getContent());

        $location = $response->headers->get('Location');
        $this->assertEmpty($location, 'Empty Location header');

    }

    /**
     * @depends testAddBrowser
     */
    public function testGetBrowser($link)
    {
        $this->client->request('GET', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddBrowser
     */
    public function testEditBrowser($link)
    {

        $this->client->request('PATCH', $link.'/modify.json',[
            'browser' => [
                'name' => 'TestBrowser-Edited'
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddBrowser
     */
    public function testGetBrowsersList()
    {
        $this->client->request('GET', '/api/v1/browsers/all.json');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());

        $json = json_decode($response->getContent());

        $this->assertTrue(count($json) > 0, $response->getContent());

    }

    /**
     * @depends testAddBrowser
     */
    public function testRemoveBrowser($link)
    {
        $this->client->request('DELETE', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddBrowser
     */
    public function testRemoveBrowserNotFound($link)
    {
        $this->client->request('DELETE', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddBrowser
     */
    public function testEditBrowserNotFound($link)
    {
        $this->client->request('PATCH', $link.'/modify.json',[
            'browser' => [
                'name' => 'TestBrowser-Edited'
            ]
        ]);

        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @depends testAddBrowser
     */
    public function testGetBrowserNotFound($link)
    {
        $this->client->request('GET', $link);
        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
    }


}
