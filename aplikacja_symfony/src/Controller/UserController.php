<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\UserType;
use Symfony\Component\PropertyAccess\PropertyAccess;


class UserController extends AbstractController
{
    /**
     * @Route("/user_add/{name}", name="add_user")
     */
    public function createUser(string $name): Response
    {
     
        $entityManager = $this->getDoctrine()->getManager();

        $user = new Users();
        $user->setName($name);
        $user->setStatus("none");
        
        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('Saved user '.$name);
    }

    
    /**
     * @Route("/user_show/{id}", name="show_user")
     */
    public function showUser(int $id): Response
    {
        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->find($id);


        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }
        
        return new Response('User '.$user->getName());
    }


     /**
     * @Route("/user_change_status/{id}", name="user_change_status")
     */
    public function changeStatus(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();


        $user = $this->getDoctrine()
        ->getRepository(Users::class)
        ->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $user->setStatus("set");
        $entityManager->flush();

        
        return new Response('User status '.$user->getStatus());
    }

       /**
     * @Route("/user_get_all", name="users")
     */
    public function userGetAll(): Response
    {
        $user = $this->getDoctrine()
        ->getRepository(Users::class)
        ->findAllUser();

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found'
            );
        }

        return new Response(json_encode($user));
    }


          /**
     * @Route("/form", name="add_user_form")
     */
    public function new(Request $request): Response
    {
        $check = new Users();
        $check->setName('');
        $name = "";

        $form = $this->createFormBuilder($check)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form = $this->createForm(UserType::class, $check);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $name = $task ->getName();

            $check->setName($name);
            $check->setStatus("none");
            
            $entityManager->persist($check);
            $entityManager->flush();
        }

        return $this->render('check/check.html.twig', [
            'form' => $form->createView(), 
            'name' => $name,
        ]);

    }

   
}



