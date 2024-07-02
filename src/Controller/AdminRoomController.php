<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/')]
class AdminRoomController extends AbstractController
{
    #[Route('/room', name: 'app_admin_room')]
    public function index(RoomRepository $repository): Response
    {
        if ($repository->count() == 0) {
            return $this->redirectToRoute('admin_add_room');
        }
        return $this->render('admin/room/index.html.twig', [
            'rooms' => $repository->findBy([],['name'=>'ASC']),
        ]);
    }

    #[Route('/room/new', name: 'admin_add_room')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($room);
            $manager->flush();
            return $this->redirectToRoute('app_admin_room');
        }
        return $this->render('admin/room/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/room/edit/{id}', name: 'admin_edit_room')]
    public function edit(Request $request, EntityManagerInterface $manager, Room $room): Response
    {

        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($room);
            $manager->flush();
            return $this->redirectToRoute('app_admin_room');
        }
        return $this->render('admin/room/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/room/remove/{id}', name: 'app_admin_room_remove')]
    public function remove(Room $room, EntityManagerInterface $manager): Response
    {
        $manager->remove($room);
        $manager->flush();
        return $this->redirectToRoute('app_admin_room');
    }
}
