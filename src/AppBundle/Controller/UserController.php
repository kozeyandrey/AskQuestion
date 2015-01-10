<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use AppBundle\Status;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * This method return registration form
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Template()
     */
    public function registrationAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('home');
    }
        return [
            'form' => $form->createView()
        ];
    }

    /**
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);
        $user = $this->getDoctrine()->getRepository("AppBundle:User")->findOneBy([
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ]);
        if ($user) {
            $this->get('user')->login($user);
            return $this->redirectToRoute('home');
        }
        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logoutAction(){
        $this->get('user')->logout();
        return $this->redirectToRoute('home');
    }
}