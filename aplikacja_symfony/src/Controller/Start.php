<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class Start extends AbstractController
{
    /**
     * @Route("/", name="start")
     */
    public function index(Request $request): Response
    {
        return $this->render('start.html.twig');
    }
}
