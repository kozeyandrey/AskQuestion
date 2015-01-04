<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Question;

class LoadQuestion extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $tag = $manager->getRepository("AppBundle:Tag")->findOneByName("Github");
        $question = new Question();
        $question->setName("How I can push to Github?");
        $question->setDescription("I don't know how push to github. Please help me!");
        $question->addTag($tag);
        $question->setViews(0);
        $question->setAnswer(0);
        $manager->persist($question);
        $manager->flush();

        $this->addReference('question', $question);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}