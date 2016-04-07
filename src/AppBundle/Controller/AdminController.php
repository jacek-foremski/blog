<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Form\Type\PostType;
use AppBundle\Form\Type\UserCreateType;
use AppBundle\Form\Type\UserEditType;
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

        $paginator = $this->get('knp_paginator');
        $paginatedUsers = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            10,
            array('defaultSortFieldName' => 'u.username', 'defaultSortDirection' => 'asc')
        );

        return $this->render(':admin/users:index.html.twig', array('paginatedUsers' => $paginatedUsers));
    }

    /**
     * @Route("/users/create", name="admin_users_create")
     */
    public function usersCreateAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserCreateType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $user->getPassword();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'User has been added');
            return $this->redirectToRoute('admin_users_index');
        }

        return $this->render(':admin/users:create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/users/{id}/edit", name="admin_users_edit", requirements={"id" = "\d+"})
     */
    public function usersEditAction(Request $request, $id)
    {
        $userRepository = $this->getDoctrine()->getRepository('AppBundle:User');
        $user = $userRepository->find($id);

        $form = $this->createForm(UserEditType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'User has been edited');
            return $this->redirectToRoute('admin_users_index');
        }

        return $this->render(':admin/users:edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/users/{id}/remove", name="admin_users_remove", requirements={"id" = "\d+"})
     */
    public function usersRemoveAction(Request $request, $id)
    {
        $userRepository = $this->getDoctrine()->getRepository('AppBundle:User');
        $user = $userRepository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'User has been removed');
        return $this->redirectToRoute('admin_users_index');
    }

    /**
     * @Route("/posts", name="admin_posts_index")
     */
    public function postsAction(Request $request)
    {
        $postRepository = $this->getDoctrine()->getRepository('AppBundle:Post');
        $posts = $postRepository->createQueryBuilder('p');

        $paginator = $this->get('knp_paginator');
        $paginatedPosts = $paginator->paginate(
            $posts,
            $request->query->getInt('page', 1),
            10,
            array('defaultSortFieldName' => 'p.title', 'defaultSortDirection' => 'asc')
        );

        return $this->render(':admin/posts:index.html.twig', array('paginatedPosts' => $paginatedPosts));
    }

    /**
     * @Route("/posts/create", name="admin_posts_create")
     */
    public function postsCreateAction(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Post has been added');
            return $this->redirectToRoute('admin_posts_index');
        }

        return $this->render(':admin/posts:create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/posts/{id}/edit", name="admin_posts_edit", requirements={"id" = "\d+"})
     */
    public function postsEditAction(Request $request, $id)
    {
        $postRepository = $this->getDoctrine()->getRepository('AppBundle:Post');
        $post = $postRepository->find($id);

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Post has been edited');
            return $this->redirectToRoute('admin_posts_index');
        }

        return $this->render(':admin/posts:edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/posts/{id}/remove", name="admin_posts_remove", requirements={"id" = "\d+"})
     */
    public function postsRemoveAction(Request $request, $id)
    {
        $postRepository = $this->getDoctrine()->getRepository('AppBundle:Post');
        $post = $postRepository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        $this->addFlash('success', 'Post has been removed');
        return $this->redirectToRoute('admin_posts_index');
    }
    
}