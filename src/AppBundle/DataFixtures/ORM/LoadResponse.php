<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Response;

class LoadResponse extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $response = new Response();
        $question = $manager->getRepository("AppBundle:Question")->findOneByTitle('string');
        $response->setQuestion($question);
        $response->setDescription("http://eax.me/git-commands/");
        $response->setCode("<php? echo 'Hello world'; ");

        $manager->persist($response);
        $manager->flush();

        $this->addReference('response1', $response);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}
