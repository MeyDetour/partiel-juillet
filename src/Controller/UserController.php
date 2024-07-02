<?php

namespace App\Controller;

use App\Entity\PayMethode;
use App\Form\PayMethodeType;
use App\Form\UserType;
use App\Repository\PayMethodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/profile')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_profil')]
    public function show( Request $request, EntityManagerInterface $manager): Response
    {
        if(!$this->getUser())
        {
            return $this->redirectToRoute('app_login');
        }
        $methode = new PayMethode();
        $form = $this->createForm(PayMethodeType::class, $methode);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $methode->setOwner($this->getUser());
            $manager->persist($methode);
            $manager->flush();
            return $this->redirectToRoute('app_profil');
        }
        return $this->render('client/user/show.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit', name: 'app_profil_edit')]
    public function edit(Request $request, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(UserType::class, $this->getUser());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($this->getUser());
            $manager->flush();
            return $this->redirectToRoute('app_profil');
        }
        return $this->render('client/user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
