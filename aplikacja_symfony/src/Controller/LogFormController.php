<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class LogFormController extends AbstractController
{
    /**
     * @Route("/", name="start")
     */
    public function index(Request $request): Response
    {


        $greet = '';
        $message = '';

        if ($name = $request->query->get('name')){
            $greet = htmlspecialchars($name);
            $message = "Hellow";
        }


        return $this->render('login_page.html.twig', [
            'name' => $greet, 
            'message' => $message,
            ]);
    }
}
