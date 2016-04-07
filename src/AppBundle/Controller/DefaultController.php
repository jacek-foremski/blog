<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $postRepository = $this->getDoctrine()->getRepository('AppBundle:Post');
        $posts = $postRepository->findAllActive();

        $paginator = $this->get('knp_paginator');
        $paginatedPosts = $paginator->paginate(
            $posts,
            $request->query->getInt('page', 1),
            3,
            array('defaultSortFieldName' => 'p.createdAt', 'defaultSortDirection' => 'desc')
        );

        return $this->render('default/index.html.twig', array('paginatedPosts' => $paginatedPosts));
    }
}
