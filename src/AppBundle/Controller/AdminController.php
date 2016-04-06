<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_homepage")
     */
    public function homepageAction(Request $request)
    {
        return $this->render(':admin/default:index.html.twig');
    }

    /**
     * @Route("/users", name="admin_users_index")
     */
    public function usersAction(Request $request)
    {
        $userRepository = $this->getDoctrine()->getRepository('AppBundle:User');
        $users = $userRepository->createQueryBuilder('u');

        $paginator  = $this->get('knp_paginator');
        $paginatedUsers = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            10,
            array('defaultSortFieldName' => 'u.username', 'defaultSortDirection' => 'asc')
        );

        return $this->render(':admin/users:users.html.twig', array('paginatedUsers' => $paginatedUsers));
    }

}