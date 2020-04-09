<?php

namespace App\Controller;

use App\Entity\Agenda;
use App\Repository\AgendaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/agenda", name="agenda_")
 */
class AgendaController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(AgendaRepository $agenda)
    {
        return $this->render("agenda/index.html.twig", [
            'agenda' => $agenda->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Agenda $agenda): Response
    {
        return $this->render('agenda/show.html.twig', [
            'agenda' => $agenda,
        ]);
    }
}
