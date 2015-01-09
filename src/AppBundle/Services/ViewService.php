<?php

namespace AppBundle\Services;

use AppBundle\Entity\Question;

class ViewService
{
    private $object;
    public function view(Question $object){
        $this->object = $object;
        $object->setViews($object->getViews() + 1);
    }

}