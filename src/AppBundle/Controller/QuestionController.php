<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Response;
use AppBundle\Form\Type\AskQuestionType;
use AppBundle\Form\Type\ResponseType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Question;
use Symfony\Component\HttpFoundation\Request;

class QuestionController extends Controller
{
    public function manager(){
        return $this->getDoctrine()->getManager();
    }
    /**
     * This method show the form for ask question
     *
     * @param Request $request
     * @return array
     *
     * @Template()
     */
    public function askAction(Request $request)
    {
        $question = new Question();
        $form = $this->createForm(new AskQuestionType(), $question);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $question->setTags($form->get('tags')->getData());
            $this->manager()->persist($question);
            $this->manager()->flush();
            return $this->redirectToRoute('ask', ['slug' => $question->getSlug()]);
            }
        return $this->render('AppBundle:Question:ask.html.twig', array(
            'form' => $form->createView()));
    }

    /**
     * This method show all questions
     *
     * @param Request $request
     * @return array
     *
     * @Template
     */
    public function allAction(Request $request){
        $questions = $this->manager()->getRepository("AppBundle:Question")->findAll();
        $paginator  = $this->get('knp_paginator');
        $questions = $paginator->paginate(
            $questions,
            $request->query->get('page', 1),
            7
        );
        return [
            "questions"=>$questions
        ];
    }

    /**
     *  This method show all unanswered questions
     *
     * @return array
     *
     * @Template()
     */
    public function unansweredAction(){
        $questions = $this->manager()->getRepository("AppBundle:Question")->findAll();
        return [
            "questions"=>$questions
        ];
    }

    /**
     * This method render information about question
     *
     * @param $slug
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Template()
     */
    public function viewAction(Request $request,$slug){
        $question = $this->manager()->getRepository("AppBundle:Question")->findOneBySlug($slug);
        $title = $this->manager()->getRepository("AppBundle:Question")->findOneByTitle($question->getTitle());
        $response = new Response();
        $form = $this->createForm(new ResponseType(), $response);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $response->setQuestion($title);
            $this->manager()->persist($response);
            $this->manager()->flush();
            return $this->redirectToRoute('view', ['slug' => $slug]);
        }
        dump($question->getTitle());
        return [
            'question'=>$question,
            'form' => $form->createView()
        ];
    }
}
