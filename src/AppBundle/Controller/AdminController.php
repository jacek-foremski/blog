<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_homepage")
     */
    public function homepageAction()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/users", name="admin_users_index")
     */
    public function usersAction()
    {
        return $this->render('admin/users.html.twig');
    }

}