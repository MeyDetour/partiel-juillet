<?php

namespace App\Controller;

use App\Entity\PayMethode;
use App\Form\PayMethodeType;
use App\Repository\PayMethodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/profile')]
class PayMethodeController extends AbstractController
{
    #[Route('/paymethode', name: 'app_pay_methode')]
    public function index(PayMethodeRepository $repository): Response
    {
        if ($repository->count([]) == 0) {
            return $this->redirectToRoute('add_pay_methode');
        }
        return $this->render('client/pay_methode/index.html.twig', [
            'methodes' => $repository->findAll()
        ]);
    }


    #[Route('/paymethode/new', name: 'add_pay_methode')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {

        $methode = new PayMethode();
        $form = $this->createForm(PayMethodeType::class, $methode);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $methode->setOwner($this->getUser());
            $manager->persist($methode);
            $manager->flush();
            return $this->redirectToRoute('app_pay_methode');
        }
        return $this->render('client/pay_methode/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/paymethode/edit/{id}', name: 'edit_pay_methode')]
    public function edit(Request $request, EntityManagerInterface $manager, PayMethode $methode): Response
    {

        $form = $this->createForm(PayMethodeType::class, $methode);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($methode);
            $manager->flush();
            return $this->redirectToRoute('app_pay_methode');
        }
        return $this->render('client/pay_methode/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/paymethode/remove/{id}', name: 'pay_methode_remove')]
    public function remove(PayMethode $payMethode, EntityManagerInterface $manager): Response
    {
        $manager->remove($payMethode);
        $manager->flush();
        return $this->redirectToRoute('app_pay_methode');
    }
}
