<?php

namespace App\Controller;

use App\Entity\Agenda;
use App\Entity\AgendaComment;
use App\Form\AgendaType;
use App\Form\CommentType;
use App\Repository\AgendaCommentRepository;
use App\Repository\AgendaRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/backoffice", name="backoffice_")
 */
class BackofficeController extends AbstractController
{
    /**
     * Liste des agendas
     * 
     * @Route("/", name="index")
     */
    public function index(AgendaRepository $agenda, UsersRepository $user)
    {
        return $this->render("backoffice/index.html.twig", [
            'agenda' => $agenda->findAll(),
            'user' => $user->findAll()
        ]);
    }

    /**
     * @Route("/new", name="agenda_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $agenda = new Agenda();
        $form = $this->createForm(AgendaType::class, $agenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agenda);
            $entityManager->flush();

            return $this->redirectToRoute('backoffice_index');
        }

        return $this->render('backoffice/newagenda.html.twig', [
            'agenda' => $agenda,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modifier Agenda
     * 
     * @Route("/backoffice/modifier/{id}", name="modifier_agenda")
     */
    public function editAgenda(Agenda $agenda, Request $request)
    {
        $form = $this->createForm(AgendaType::class, $agenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agenda);
            $entityManager->flush();

            $this->addFlash('message', 'Agenda modifié avec succès');
            return $this->redirectToRoute('backoffice_index');
        }

        return $this->render('backoffice/editagenda.html.twig', [
            'agendaForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Agenda $agenda): Response
    {
        return $this->render('backoffice/show.html.twig', [
            'agenda' => $agenda,
        ]);
    }

    /**
     * @Route("/{id}", name="delete_agenda", methods={"DELETE"})
     */
    public function delete(Request $request, Agenda $agenda): Response
    {
        if ($this->isCsrfTokenValid('delete' . $agenda->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($agenda);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backoffice_index');
    }

    /**
     * @Route("/create/{id}", name="create_comment", methods={"GET","POST"})
     */
    public function create(AgendaComment $com, Request $request): Response
    {
        $com = new AgendaComment();
        $form = $this->createForm(CommentType::class, $com);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($com);
            $entityManager->flush();

            return $this->redirectToRoute('agenda_index');
        }

        return $this->render('backoffice/createcom.html.twig', [
            'commentForm' => $form->createView(),
        ]);
    }
}
