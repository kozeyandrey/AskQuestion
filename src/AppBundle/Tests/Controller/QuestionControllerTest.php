<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class ProductControllerTest extends WebTestCase
{

    public function testAsk()
    {
        $client = static::createClient();
        $container = self::$kernel->getContainer();
        $crawler = $client->request('GET', $container->get('router')->generate('ask'));
        $this->assertTrue($crawler->count() > 0);
        $crawler = $client->request('GET', '/ask');
        $this->assertCount(1, $crawler->selectButton('Send'));
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }
    public function testAll()
    {
        $client = static::createClient();
        $container = self::$kernel->getContainer();
        $crawler = $client->request('GET', $container->get('router')->generate('all'));
        $this->assertTrue($crawler->count() > 0);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }
    public function testUnanswered()
    {
        $client = static::createClient();
        $container = self::$kernel->getContainer();
        $crawler = $client->request('GET', $container->get('router')->generate('unanswered'));
        $this->assertTrue($crawler->count() > 0);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }

}