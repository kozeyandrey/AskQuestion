<?php

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class ViewQuestionEvent extends Event
{
    private $slug;

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }
}