<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Response;
use AppBundle\Form\Type\AskQuestionType;
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
            $this->manager()->persist($question);
            $this->manager()->flush();
            return $this->redirect($this->generateUrl('home'));
            }
        return $this->render('AppBundle:Question:ask.html.twig', array(
            'form' => $form->createView()));
    }
}
