<?php

namespace App\Controller\Back;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackHomeController extends AbstractController
{
    /**
     * @Route("/back", name="back_home")
     * Here the back home index gives the alert message to the admin incase of the reservation not validated within 5 days of time 
     */
    public function index(ReservationRepository $reservationRepository): Response
    {  
        $reservationAlerts= $reservationRepository->findAlert();
     
        return $this->render('back/back_home/index.html.twig', [
            'reservationAlerts' => $reservationAlerts,
        ]);

    }
    /**
     * @Route("/back/{id}/valider", name="back_home_valider", methods={"GET"})
     * This function is to change the status of the reservation to valider inshort to approuve it  by the admin if all the reservation 
     * is processed then it will be redirected to admin confirmation page
     */
    public function valider(Reservation $reservation, ReservationRepository $reservationRepository, EntityManagerInterface $entityManager): Response
    {
        $reservation->setStatus(Reservation::STATUS_VALIDER);
        $entityManager->persist($reservation);
        $entityManager->flush();

        $reservationAlert=$reservationRepository->findAlert();

        if(!$reservationAlert){
            return $this->redirectToRoute('back_home_confirmation', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->redirectToRoute('back_home', [], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/back/{id}/annuler", name="back_home_annuler", methods={"GET"})
     * this function is to cancel the reservations. function findalert is called again if incase the annulation is done at the 
     * back user home page when showing the alert message
     */
    public function annuler(Reservation $reservation, ReservationRepository $reservationRepository, EntityManagerInterface $entityManager): Response
    {
        $reservation->setStatus(Reservation::STATUS_ANNULER);
        $entityManager->persist($reservation);
        $entityManager->flush();

        $reservationAlert=$reservationRepository->findAlert();

        if(!$reservationAlert){
            return $this->redirectToRoute('back_home_confirmation', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->redirectToRoute('back_home', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/back/confirmation", name="back_home_confirmation", methods={"GET"})
    */
    public function confirmation(): Response
    {
        return $this->render('back/back_home/confirmation.html.twig');
    }
}
