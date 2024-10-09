<?php

namespace App\Controller\Front;

use App\Entity\Hall;
use App\Repository\HallRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HallController extends AbstractController
{
    /**
     * @Route("/hall", name="hall_index", methods={"GET"})
     */
    public function index(HallRepository $hallRepository): Response
    {
        return $this->render('front/hall/index.html.twig', [
            'halls' => $hallRepository->findAll(),
        ]);
    }


    /**
     * @Route("/hall/{id}", name="hall_show", methods={"GET"})
     */
    public function show(Hall $hall): Response
    {
        return $this->render('front/hall/show.html.twig', [
            'hall' => $hall,
        ]);
    }

  
}
