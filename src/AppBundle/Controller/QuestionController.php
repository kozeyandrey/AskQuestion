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
use AppBundle\Entity\Tag;

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
            foreach ($request->request->get('tag') as $one_tag) {
                $tag = new Tag();
                $find = $this->manager()->getRepository('AppBundle:Tag')->findOneByName($one_tag);
                if ($find) {
                    $question->AddTag($find);
                }else{
                    $tag->setName($one_tag);
                    $question->AddTag($tag);
                }
            }
            $this->manager()->persist($question);
            $this->manager()->flush();
            return $this->redirectToRoute('home');
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
     * @param Request $request
     * @return array
     *
     * @Template()
     */
    public function unansweredAction(Request $request){
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
     *  This method render information about question
     *
     * @param Request $request
     * @param Question $question
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @ParamConverter("question", options={"mapping": {"slug": "slug"}})
     *
     * @Template()
     */
    public function viewAction(Request $request,Question $question){
        $title = $this->manager()->getRepository("AppBundle:Question")->findOneByTitle($question->getTitle());
        $response = new Response();
        $form = $this->createForm(new ResponseType(), $response);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $response->setQuestion($title);
            $this->manager()->persist($response);
            $this->manager()->flush();
            return $this->redirectToRoute('view', ['slug' => $question->getSlug()]);
        }
        return [
            'question'=>$question,
            'form' => $form->createView()
        ];
    }
}
