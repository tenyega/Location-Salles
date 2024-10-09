<?php

namespace App\Controller\Front;

use App\Entity\FrontUser;
use App\Entity\Hall;
use DateTime;
use App\Entity\Reservation;
use App\Form\FrontUserReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToLocalizedStringTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/front/reserver/{id}", name="front_user_reserver")
     * This is the reservation function at the front end 
     * For the dates after form submission.
     *  - first the start date and time is checked for the date after todays date and time  
     *  - then the end date and time is checked for the date after todays date and time 
     *  - at the end the two dates and times  entered by the user is checked to verify is the end date is clearly after the start date  
     *Then the checkdates() of the reservation repository is called to find if the dates entered by the user is available for the
     * for the reservation, returns null if theres no reservation already on these dates given.
     * so when the checkdates() returns null then only we add the data to the reservation table.
     * and if the checkdates() returns a value then it means that we already have a reservation for these dates so the error() is called to 
     * show the message to clients 
     * 
     * When the form is rendered the hall from the auto wiring of the slug id and the form view is given at the same time
    */
    public function reserver(Hall $hall, Request $request, EntityManagerInterface $entityManager)
    {
        $reservation = new Reservation();
        $form = $this->createForm(FrontUserReservationType::class, $reservation);
        $form->handleRequest($request);

        $frontuser = $this->getUser();
        $frontuseremail=$frontuser->getUsername($frontuser);

        $frontuserRepository= $this->getDoctrine()->getRepository(FrontUser::class);
        $frontuser=$frontuserRepository->findSomeOne($frontuseremail);
        
            if ($form->isSubmitted() && $form->isValid()) {

                $formdata=$form->getData();

                $reservationStartDate=$formdata->getStartdate();
                $reservationEndDate= $formdata->getEnddate();
                $today= new DateTime('now');
                if($reservationStartDate >= $today)
                {
                    if($reservationEndDate >= $today)
                    {
                        if($reservationEndDate> $reservationStartDate)
                        {
                            $reservationRepository= $this->getDoctrine()->getRepository(Reservation::class);

                            $possibleOrNot= $reservationRepository->checkDates($reservationStartDate,$reservationEndDate,$hall);
                            if($possibleOrNot== NULL)
                            {
                                $reservation->setStatus(Reservation::STATUS_PENDING);
                                $reservation->setHall($hall);
                                $reservation->setFrontUser($frontuser);
                                $entityManager->persist($reservation);
                                $entityManager->flush();
            
                                return $this->redirectToRoute('front_user_mesreservation', [], Response::HTTP_SEE_OTHER);
                            }else {
                                return $this->redirectToRoute('front_user_error');
                            }
                        }else {
                            echo "Date de debut et l'heure peut pas etre apres date de fin";
                        }
                    }else {
                        echo "Entrez une date et l'heure de fin  valide";
                    }
                    
                }else {
                    echo "Entrez une date et l'heure de début valide";
                }
               
            }    
        return $this->render('front/reservation/reserver.html.twig', [
            'hall'=>$hall,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/front/mesreservation", name="front_user_mesreservation")
     * This function returns the reservation as per the active front user 
    */
    public function mesreservation(ReservationRepository $repository)
    {
    
        $frontuser = $this->getUser();
        $frontuserRepository= $this->getDoctrine()->getRepository(FrontUser::class);
        $frontuseremail=$frontuser->getUsername($frontuser);
        $frontuser=$frontuserRepository->findSomeOne($frontuseremail);
        $mesreservations= $frontuser->getReservation();

        return $this->render('front/reservation/mesreservation.html.twig', [
           'mesreservations'=> $mesreservations,
        ]);
    }
    
    /**
     * @Route("/front/{id}/modify", name="front_user_modify")
     *Here this function is used by the front user to modify the reservation and after every modification the status of the 
     * reservation is updated to pending so that the admin can re verify for the disponibility again.
     * Here in this case the date is also checked again to verify if theres a reservation already on that hall 
     * 
    */
    public function modify(Request $request, Reservation $reservation, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(FrontUserReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formdata=$form->getData();

            $reservationStartDate=$formdata->getStartdate();
            $reservationEndDate= $formdata->getEnddate();
            $today= new DateTime('now');
            $hall=$reservation->getHall();
            if($reservationStartDate >= $today)
            {
                if($reservationEndDate >= $today)
                {
                    if($reservationEndDate> $reservationStartDate)
                    {
                        $reservationRepository= $this->getDoctrine()->getRepository(Reservation::class);

                        $possibleOrNot= $reservationRepository->checkDates($reservationStartDate,$reservationEndDate,$hall);
                        if($possibleOrNot== NULL)
                        {
                            $reservation->setStatus(Reservation::STATUS_PENDING);
                            $entityManager->flush();

                            return $this->redirectToRoute('front_user_mesreservation', [], Response::HTTP_SEE_OTHER);
                        }else {
                            return $this->redirectToRoute('front_user_error');
                        }
                    }else {
                        echo "Date de debut et l'heure peut pas etre apres date de fin";
                    }
                }else {
                    echo "Entrez une date et l'heure de fin  valide";
                }
                
            }else {
                echo "Entrez une date et l'heure de début valide";
            }
        }

        return $this->renderForm('front/reservation/modify.html.twig', [
            'reservation'=>$reservation,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/front/{id}/annuler", name="front_user_annuler", methods={"GET"})
     * The front user can also cancel his reservation from his interface. 
     */
    public function annuler(Reservation $reservation, ReservationRepository $reservationRepository, EntityManagerInterface $entityManager): Response
    {
        $reservation->setStatus(Reservation::STATUS_ANNULER);
        $entityManager->persist($reservation);
        $entityManager->flush(); 
        
        return $this->redirectToRoute('front_user_mesreservation', [], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/front/error", name="front_user_error", methods={"GET"})
     * This page is used to display when the dates given by the user is already booked by another person.
     */
    public function error(): Response
    {
        return $this->render('front/reservation/error.html.twig');
    }
}
