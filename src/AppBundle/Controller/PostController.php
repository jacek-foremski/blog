<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PostController extends Controller
{
    /**
     * @Route("/post/{slug}", name="show_post", requirements={"slug" = "[a-zA-Z1-9\-\/]+"})
     */
    public function indexAction(Request $request, $slug)
    {
        $postRepository = $this->getDoctrine()->getRepository('AppBundle:Post');
        $post = $postRepository->findOneBy(array('slug' => $slug));

        if (!$post || !$post->getIsActive()) {
            throw $this->createNotFoundException('The post does not exist');
        }

        return $this->render(':post:show.html.twig', array('post' => $post));
    }

    /**
     * @Route("/archives", name="archives")
     */
    public function archivesAction(Request $request)
    {
        $postRepository = $this->getDoctrine()->getRepository('AppBundle:Post');
        $distinctMonths = $postRepository->findDistinctCreationDateMonths();

        return $this->render(':post:archives.html.twig', array('distinctMonths' => $distinctMonths));
    }

    /**
     * @Route("/archive/{month}", name="archive")
     * @ParamConverter("month", options={"format": "Y-m"})
     */
    public function archiveAction(Request $request, \DateTime $month)
    {
        $postRepository = $this->getDoctrine()->getRepository('AppBundle:Post');
        $posts = $postRepository->findAllActiveInMonth(new \DateTime($month->format('Y-m')));

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
