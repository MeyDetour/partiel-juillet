<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminFilmController extends AbstractController
{
    #[Route('/film', name: 'app_admin_film')]
    public function index(FilmRepository $repository): Response
    {
        if ($repository->count([]) == 0) {
            return $this->redirectToRoute('admin_add_film');
        }
        return $this->render('admin/admin_film/index.html.twig', [
            'films' => $repository->findAll()
        ]);
    }    #[Route('/film/show/{id}', name: 'app_admin_film_show')]
    public function show(Film $film): Response
    {
        return $this->render('admin/admin_film/index.html.twig', [
            'film' => $film
        ]);
    }

    #[Route('/film/new', name: 'admin_add_film')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($film);
            $manager->flush();
            return $this->redirectToRoute('admin_add_image_film', ['id' => $film->getId()]);
        }
        return $this->render('admin/admin_film/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
