<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\EntityManager;
use AppBundle\Event\ViewQuestionEvent;

class ViewEventListener
{
    /**
     * @var $manager \Doctrine\ORM\EntityManager
     */
    private $manager;

    public function __construct(EntityManager $entityManager)
    {
        $this->manager = $entityManager;
    }
    public function onViewQuestion(ViewQuestionEvent $event)
    {
        $slug = $event->getSlug();
        /**
         * @var $views \AppBundle\Entity\Question
         */
        $views = $this->manager->getRepository('AppBundle:Question')->findOneBySlug($slug);
        $views->setViews($views->getViews() + 1);
        $this->manager->persist($views);
        $this->manager->flush();
    }
}