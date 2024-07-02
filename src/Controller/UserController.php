<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/profile')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_profil')]
    public function show(): Response
    {
        if(!$this->getUser())
        {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('client/user/show.html.twig', [

        ]);
    }
}
