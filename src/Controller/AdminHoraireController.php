<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Horair;
use App\Form\HorairType;
use App\Repository\FilmRepository;
use App\Repository\HorairRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminHoraireController extends AbstractController
{
    #[Route('/horaire', name: 'app_admin_horaire')]
    public function index(HorairRepository $repository): Response
    {
        if ($repository->count() == 0) {
            return $this->redirectToRoute('admin_add_horaire');
        }
        return $this->render('admin/admin_film/horaire/index.html.twig', [
            'horaires' => $repository->findAll(),
        ]);
    }

    #[Route('/horaire/new', name: 'admin_add_horaire')]
    #[Route('/horaire/film/{id}/new', name: 'admin_add_horaire_to_film')]
    public function new(Request $request, EntityManagerInterface $manager, ?Film $film, FilmRepository $filmRepository, HorairRepository $horairRepository): Response
    {
        $route = $request->attributes->get('_route');

        if ($filmRepository->count() == 0) {
            return $this->redirectToRoute('app_admin_film');
        }

        $horaire = new Horair();
        $form = $this->createForm(HorairType::class, $horaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

          if($horairRepository->findBy(['room'=>$horaire->getRoom(),'hour'=>$horaire->getHour(),'date'=>$horaire->getDate()])) {
              dd('il y a deja une seance a cette horaire');
          }
          else{
              $manager->persist($horaire);
              $manager->flush();

              if ($route == 'admin_add_horaire') {

                  return $this->redirectToRoute('app_admin_horaire');
              }
              return $this->redirectToRoute('app_admin_film_show', ['id' => $film->getId()]);

          }


        }
        return $this->render('admin/admin_film/horaire/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/horaire/edit/{id}', name: 'admin_edit_horaire')]
    #[Route('/horaire/film/edit/{id}', name: 'admin_edit_horaire_from_film')]
    public function edit(Request $request, EntityManagerInterface $manager, Horair $horaire): Response
    {
        $route = $request->attributes->get('_route');

        $form = $this->createForm(HorairType::class, $horaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($horaire);
            $manager->flush();
            if ($route == 'admin_edit_horaire') {

                return $this->redirectToRoute('app_admin_horaire');
            }
            return $this->redirectToRoute('app_admin_film_show', ['id' => $horaire->getFilm()->getId()]);
        }

        return $this->render('admin/admin_film/horaire/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/horaire/remove/{id}', name: 'app_admin_horaire_remove')]
    #[Route('/horaire/film/remove/{id}', name: 'app_admin_horaire_remove_from_film')]
    public function remove(Request $request, Horair $horaire, EntityManagerInterface $manager): Response
    {
        $route = $request->attributes->get('_route');
        $id = $horaire->getFilm()->getId();
        $horaire->getFilm()->removeHorair($horaire);
        $manager->remove($horaire);
        $manager->flush();
        if ($route == 'app_admin_horaire_remove') {

            return $this->redirectToRoute('app_admin_horaire');
        }
        return $this->redirectToRoute('app_admin_film_show', ['id' => $id]);

    }
}
