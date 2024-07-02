<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Horair;
use App\Entity\Reservation;
use App\Repository\HorairRepository;
use App\Repository\PayMethodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation/{id}', name: 'new_reservation')]
    public function index(Film $filmn, HorairRepository $horairRepository): Response
    {
        return $this->render('client/reservation/index.html.twig', [
            'data' => $horairRepository->findBy(['film' => $filmn], ['date' => 'ASC', 'hour' => 'ASC'])
        ]);
    }

    #[Route('/reserve/{id}/{places}/{payMethodeId}/accept;', name: 'to_reserve')]
    public function buy(EntityManagerInterface $manager, Horair $horair, int $places, int $payMethodeId, PayMethodeRepository $repository): Response
    {
        $reservation = new Reservation();
        $reservation->setCreatedAt(new \DateTimeImmutable());
        $reservation->setOwner($this->getUser());
        $reservation->setHorair($horair);
        $reservation->setNbPlace(
            $places
        );
        $reservation->setPayement($repository->find($payMethodeId));
        $reservation->setPrice(7.50 * $places);
        $manager->persist($reservation);
        $manager->flush();
        $this->addFlash('success', 'Reservation réussie !');
        return $this->redirectToRoute('app_home');
    }

    #[Route('/reserve/{id}/{places}/{payMethodeId}', name: 'accept_payement')]
    public function reserve(Horair $horair, $places, $payMethodeId, PayMethodeRepository $payMethodeRepository): Response
    {

        return $this->render('client/reservation/toaccept.html.twig', [
            'horaire' => $horair,
            'places' => $places,
            'payMethode' => $payMethodeRepository->find($payMethodeId)]);
    }

    #[Route('/reserve/{id}/{places}', name: 'choose_payement')]
    public function choosePayement(Horair $horair, $places): Response
    {

        return $this->render('client/reservation/payement.html.twig', [
            'horaire' => $horair,
            'places' => $places
        ]);
    }

    #[Route('/reserver/{id}', name: 'to_reserve_place')]
    public function reservePlace(Horair $horair): Response
    {

        return $this->render('client/reservation/place.html.twig', [
            'horaire' => $horair
        ]);
    }

    #[Route('/reserver/remove/{id}', name: 'remove_resa')]
    public function remove(Reservation $reservation, EntityManagerInterface $manager): Response
    {

        $horaire = $reservation->getHorair();
        $dateOfSeance = clone $horaire->getDate();
        $dateOfSeance->setTime($horaire->getHour()->format('H'), $horaire->getHour()->format('i'), $horaire->getHour()->format('s'));

        $today = new \DateTime();
        $interval = $dateOfSeance->diff($today);

        if ($interval->days == 0 && $interval->h == 0 && $interval->i < 10) {

            dd('impossible de supprimer la reservation, elle commence dans 10 mion ! ');

            return $this->redirectToRoute('app_home');
        }
        $manager->remove($reservation);
        $manager->flush();
        return $this->redirectToRoute('app_profil');
    }

}
