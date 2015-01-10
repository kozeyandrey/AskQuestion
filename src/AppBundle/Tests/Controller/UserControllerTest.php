<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    /**
     * @dataProvider providerData
     */
    public function testRegistration($email,$password)
    {
        self::bootKernel();
        $manager = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
        $client = static::createClient();
        $crawler = $client->request('GET', '/registration');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $form = $crawler->selectButton('Send')->form();
        $form['User[email]'] = $email;
        $form['User[password]'] = $password;
        $crawler = $client->submit($form);
        $user = $manager->getRepository('AppBundle:User')->findOneByEmail($email);
        $this->assertEquals($user->getEmail(),$email);
        $this->assertEquals($user->getPassword(),$password);
    }
    /**
     * @dataProvider providerData
     */
    public function testLogin($email,$password)
    {
        self::bootKernel();
        $manager = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $user = $manager->getRepository('AppBundle:User')->findOneByEmail($email);
        $this->assertEquals($user->getEmail(),$email);
        $this->assertEquals($user->getPassword(),$password);
    }
    public function providerData(){
        return [
            ["example@gmail.com",'12345'],
            ['root@gmail.com','54321']
        ];
    }
}
