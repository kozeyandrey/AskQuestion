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
        $question = new Question();

        $question->setTitle("string")
            ->setDescription("string")
            ->setCode('string')
            ->addTag($this->getReference('tag-github'),$this->getReference('tag-github'),$this->getReference('tag-github'))
            ->addResponse($this->getReference('response1'))
            ->setLike(1)
            ->setDislike(1)
            ->setAnswer(1)
            ->setViews(1)
        ;

        $manager->persist($question);
        $manager->flush();

        $this->addReference('question', $question);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}
