<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FilmRepository $filmRepository): Response
    {

        return $this->render('client/home/index.html.twig', [
'films'=>$filmRepository->findAll()
        ]);
    }
}
