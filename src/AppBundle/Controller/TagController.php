<?php

namespace AppBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Tag;
use Symfony\Component\HttpFoundation\Request;

class TagController extends Controller
{
    /**
     * This method render all tags
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
            'tags'=>$tags,
            'user' => $this->get('user')->getInfo(),
        ];
    }

    /**
     * This method render all question this tag
     *
     * @param Tag $tag
     * @return array
     * @ParamConverter("tag", options={"mapping": {"slug": "slug"}})
     *
     * @Template()
     */
    public function viewAction(Tag $tag){
        return[
          'tag'=>$tag,
          'user' => $this->get('user')->getInfo()
        ];
    }
}
