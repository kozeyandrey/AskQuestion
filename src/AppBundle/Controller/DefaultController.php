<?php

namespace AppBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Question;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
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
        $questions = $this->getDoctrine()->getManager()->getRepository("AppBundle:Question")->findAll();
        $paginator  = $this->get('knp_paginator');
        $questions = $paginator->paginate(
            $questions,
            $request->query->get('page', 1),
            10
        );

        return [
            'questions'=>$questions
        ];
    }
}
