<?php

namespace App\Controller;

use App\Entity\Film;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FilmController extends AbstractController
{
    #[Route('/films', name: 'app_film')]
    public function index(FilmRepository $repository): Response
    {

        return $this->render('client/film/index.html.twig', [
            'films' => $repository->findAll()
        ]);
    }

    #[Route('/film/{id}', name: 'film_show')]
    public function show(Film $film): Response
    {
        return $this->render('client/film/show.html.twig', [
            'film' => $film
        ]);
    }

}
