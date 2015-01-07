<?php

namespace AppBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Question;
use Symfony\Component\HttpFoundation\Request;

class TagController extends Controller
{
    /**
     * This method render all questions
     *
     * @param Request $request
     * @return array
     *
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $tags = $this->getDoctrine()->getManager()->getRepository("AppBundle:Tag")->findAll();
        $paginator  = $this->get('knp_paginator');
        $tags = $paginator->paginate(
            $tags,
            $request->query->get('page', 1),
            30
        );

        return [
            'tags'=>$tags
        ];
    }
}
