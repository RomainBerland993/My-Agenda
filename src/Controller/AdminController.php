<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\EditUserType;
use App\Repository\AgendaRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    // /**
    //  * @Route("/", name="index")
    //  */
    // public function index()
    // {
    //     return $this->render('admin/index.html.twig', [
    //         'controller_name' => 'BackofficeController',
    //     ]);
    // }

    /**
     * Liste des utilisateurs
     * 
     * @Route("/utilisateur", name="utilisateur")
     */
    public function userlist(UsersRepository $user, AgendaRepository $agenda)
    {
        return $this->render("admin/user.html.twig", [
            'user' => $user->findAll(),
            'agenda' => $agenda->findAll()
        ]);
    }

    /**
     * Modifier Utilisateur
     * 
     * @Route("/utilisateur/modifier/{id}", name="modifier_utilisateur")
     */
    public function editUser(Users $user, Request $request)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_utilisateur');
        }

        return $this->render('admin/edituser.html.twig', [
            'userForm' => $form->createView()
        ]);
    }
}
