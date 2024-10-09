<?php

namespace App\Controller\Back;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/reservation")
 */
class ReservationController extends AbstractController
{
    
    /**
     * @Route("/reservation", name="back_reservation_reservation", methods={"GET"})
     * This function is to display all the available reservations with its status 
     */
    public function reservation(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Reservation ::class);
        $reservations= $repository->findAll();
        
        return $this->render('back/reservation/reservation.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @Route("/{id}/valider", name="back_reservation_valider", methods={"GET"})
     * This function will change the status of the reservation, either to valider or to annuler 
     */
    public function valider(Reservation $reservation, ReservationRepository $reservationRepository, EntityManagerInterface $entityManager): Response
    {
        $reservation->setStatus(Reservation::STATUS_VALIDER);
        $entityManager->persist($reservation);
        $entityManager->flush();
        $reservationAlert=$reservationRepository->findAlert();
        if(!$reservationAlert){
            return $this->redirectToRoute('back_reservation_reservation', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->redirectToRoute('back_reservation_reservation', [], Response::HTTP_SEE_OTHER);
    }

    
    /**
     * @Route("/{id}/voir", name="back_reservation_voir", methods={"GET"})
     * This function is to see the reservation as per the id given
     */
    public function voir(Reservation $reservation): Response
    {
        $repository=$this->getDoctrine()->getRepository(Reservation ::class);
        $reservation= $repository->find($reservation);
        
        return $this->render('back/reservation/voir.html.twig', [
            'reservation' => $reservation,
        ]);
    }
   
    /**
     * @Route("/{id}/effacer", name="back_reservation_effacer", methods={"POST"})
     * This function is to delete the reservation completely from the database 
     */
    public function effacer(Request $request, reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_reservation_reservation', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/modifier", name="back_reservation_modifier", methods={"GET", "POST"})
     * This function is to modify the reservation status by admin 
     */
    public function modifier(Request $request, reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('back_reservation_reservation', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('back/reservation/modifier.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/annuler", name="back_reservation_annuler", methods={"GET"})
     * This function is to cancel the pre-reservation
     */
    public function annuler(Reservation $reservation, ReservationRepository $reservationRepository, EntityManagerInterface $entityManager): Response
    {
        $reservation->setStatus(Reservation::STATUS_ANNULER);
        $entityManager->persist($reservation);
        $entityManager->flush();
   
        return $this->redirectToRoute('back_reservation_reservation', [], Response::HTTP_SEE_OTHER);
    }
   
}
