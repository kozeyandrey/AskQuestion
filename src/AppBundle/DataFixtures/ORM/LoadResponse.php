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
        $question = $manager->getRepository("AppBundle:Question")->findOneByName("How I can push to Github?");
        $response = new Response();
        $response->setQuestion($question);
        $response->setDescription("http://eax.me/git-commands/");
        $manager->persist($response);
        $manager->flush();

        $this->addReference('response', $response);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}