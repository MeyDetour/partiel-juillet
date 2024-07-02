<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Image;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Liip\ImagineBundle\Form\Type\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/admin')]

class ImageController extends AbstractController
{
    #[Route('/image', name: 'app_image')]
    public function index(ImageRepository $imageRepository): Response
    {
        if(!$this->getUser()){
            return  $this->redirectToRoute('app_login');
        }
        return $this->render('admin/image/index.html.twig', [
            'images'=>$imageRepository->findAll()
        ]);
    }
    #[Route('/image/new', name: 'add_image')]
    public function add(Request $request , EntityManagerInterface $manager): Response
    {
        if(!$this->getUser()){
            return  $this->redirectToRoute('app_login');
        }
        $image = new Image();
        $form = $this->createForm(\App\Form\ImageType::class,$image);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($image);
            $manager->flush();
            return $this->redirectToRoute('app_image');
        }
        return $this->render('admin/image/add.html.twig', [
            'form'=>$form->createView()
        ]);
    } #[Route('/image/film/{id}new', name: 'admin_add_image_film')]
    public function addToFilm(Request $request , Film $film ,EntityManagerInterface $manager): Response
    {
        if(!$this->getUser()){
            return  $this->redirectToRoute('app_login');
        }
        $image = new Image();
        $form = $this->createForm(\App\Form\ImageType::class,$image);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $image->setFilm($film);
            $manager->persist($image);
            $manager->flush();
            return $this->redirectToRoute('app_admin_film');
        }
        return $this->render('admin/image/add.html.twig', [
            'form'=>$form->createView()
        ]);
    }
    #[Route('/image/remove/{id}', name: 'remove_image')]
    public function remove(Image $image, EntityManagerInterface $manager): Response
    {
        if(!$this->getUser()){
            return  $this->redirectToRoute('app_login');
        }
        $manager->remove($image);
        $manager->flush();
        return  $this->redirectToRoute('app_image');
    }
}
