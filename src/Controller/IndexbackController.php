<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexbackController extends AbstractController
{
    /**
     * @Route("/indexback", name="indexback")
     */
    public function index(): Response
    {
        return $this->render('indexback.html.twig', [
            'controller_name' => 'IndexbackController',
        ]);
    }



    /**
     * @Route("/billing", name="billing")
     */
    public function billing(): Response
    {
        return $this->render('billing.html.twig');
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render('dashboard.html.twig');
    }

    /**
     * @Route("/tables", name="tables")
     */
    public function tables(): Response
    {
        return $this->render('tables.html.twig');
    }

     /**
     * @Route("/notifications", name="notifications")
     */
    public function notifications(): Response
    {
        return $this->render('notifications.html.twig');
    }

    /**
     * @Route("/sign-in", name="sign-in")
     */
    public function signin(): Response
    {
        return $this->render('sign-in.html.twig');
    }

    /**
     * @Route("/sign-up", name="sign-up")
     */
    public function signup(): Response
    {
        return $this->render('sign-up.html.twig');
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(): Response
    {
        return $this->render('profile.html.twig');
    }
}
