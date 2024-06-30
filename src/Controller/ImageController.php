<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Liip\ImagineBundle\Form\Type\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ImageController extends AbstractController
{
    #[Route('/image', name: 'app_image')]
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('image/index.html.twig', [
            'images'=>$imageRepository->findAll()
        ]);
    }
    #[Route('/image/new', name: 'add_image')]
    public function add(Request $request , EntityManagerInterface $manager): Response
    {
        $image = new Image();
        $form = $this->createForm(\App\Form\ImageType::class,$image);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($image);
            $manager->flush();
            return $this->redirectToRoute('app_image');
        }
        return $this->render('image/add.html.twig', [
            'form'=>$form->createView()
        ]);
    }
    #[Route('/image/remove/{id}', name: 'remove_image')]
    public function remove(Image $image, EntityManagerInterface $manager): Response
    {
        $manager->remove($image);
        $manager->flush();
        return  $this->redirectToRoute('app_image');
    }
}
