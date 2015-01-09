<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class TagControllerTest extends WebTestCase
{
    public function testTag()
    {
        $client = static::createClient();
        $container = self::$kernel->getContainer();
        $crawler = $client->request('GET', $container->get('router')->generate('tags'));
        $this->assertTrue($crawler->count() > 0);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }
}
