<?php

namespace App\Controller;

use App\Entity\VoiceCategories;
use App\Form\VoiceCategoryType;
use App\Repository\VoiceCategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function PHPUnit\Framework\isEmpty;
#[Route('/admin')]
class AdminVoiceController extends AbstractController
{
    #[Route('/voice', name: 'app_admin_voice')]
    public function index(VoiceCategoriesRepository $repository): Response
    {
        if ($repository->count() == 0) {
            return $this->redirectToRoute('admin_add_voice');
        }
        return $this->render('admin/voice/index.html.twig', [
            'categories' => $repository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/voice/new', name: 'admin_add_voice')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $voice = new VoiceCategories();
        $form = $this->createForm(VoiceCategoryType::class, $voice);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($voice);
            $manager->flush();
            return $this->redirectToRoute('app_admin_voice');
        }
        return $this->render('admin/voice/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/voice/edit/{id}', name: 'admin_edit_voice')]
    public function edit(Request $request, EntityManagerInterface $manager, VoiceCategories $voice): Response
    {

        $form = $this->createForm(VoiceCategoryType::class, $voice);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($voice);
            $manager->flush();
            return $this->redirectToRoute('app_admin_voice');
        }
        return $this->render('admin/voice/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/voice/remove/{id}', name: 'app_admin_voice_remove')]
    public function remove(VoiceCategories $voice, EntityManagerInterface $manager): Response
    {
        if (
            count($voice->getHorairs())==0
        ) {
            $manager->remove($voice);
            $manager->flush();

        }
        return $this->redirectToRoute('app_admin_voice');

    }
}
