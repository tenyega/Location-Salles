<?php

namespace App\Controller\Back;

use App\Entity\Hall;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/halltable")
 */
class HallTableController extends AbstractController
{
      
    /**
     * @Route("/gestion", name="back_halltable_gestiontable", methods={"GET"})
     * This function is dedicated to the modification of the table of the database. 
     */
    public function gestionTable(): Response
    {
        return $this->render('back/halltable/gestionTable.html.twig');
    }

    /**
     * @Route("/hallShow", name="back_halltable_hallShow", methods={"GET"})
     * This function is to show the detailed structure of the hall table to be able to modify its details 
     */
    public function hallShow(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Hall ::class);
        $halls= $repository->findAll();
        
        return $this->render('back/halltable/hallShow.html.twig', [
            'halls' => $halls,
        ]);
    }
}
