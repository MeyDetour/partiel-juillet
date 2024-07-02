<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminDashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function index(FilmRepository $repository): Response
    {
        return $this->render('admin/admin_dashboard/index.html.twig', [
        'nb_films'=> $repository->count([])
        ]);
    }
}
