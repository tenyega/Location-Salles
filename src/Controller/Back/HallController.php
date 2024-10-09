<?php

namespace App\Controller\Back;

use App\Entity\Hall;
use App\Form\HallType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/hall")
 */
class HallController extends AbstractController
{
    /**
     * @Route("/index", name="back_hall_index", methods={"GET"})
     * this function returns all the available halls 
     */
    public function index(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Hall ::class);
        $halls= $repository->findAll();
     
        return $this->render('back/hall/index.html.twig', [
            'halls' => $halls,
        ]);
    }

    /**
     * @Route("/new", name="back_hall_new", methods={"GET", "POST"})
     * this function is used by the admin to create a new hall and redirect to the home page of the hall display ones 
     * its done 
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hall = new Hall();
        $form = $this->createForm(HallType::class, $hall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hall);
            $entityManager->flush();

            return $this->redirectToRoute('back_hall_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/hall/new.html.twig', [
            'hall' => $hall,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/show", name="back_hall_show", methods={"GET"})
     * this function shows the details of that particular hall whose id is taken from the slug of the url 
     * and brings its details with the help of auto wiring.
     */
    public function show(Hall $hall): Response
    {
        return $this->render('back/hall/show.html.twig', [
            'hall' => $hall,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="back_hall_edit", methods={"GET", "POST"})
     * This function edits the hall details by its id from the url and with the help of auto wiring, it will show the 
     * details of the hall and modify if necessary
     */
    public function edit(Request $request, Hall $hall, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HallType::class, $hall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('back_hall_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/hall/edit.html.twig', [
            'hall' => $hall,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="back_hall_delete", methods={"POST"})
     * this function deletes the hall by taking its id as a reference 
     */
    public function delete(Request $request, Hall $hall, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hall->getId(), $request->request->get('_token'))) {
            $entityManager->remove($hall);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_hall_index', [], Response::HTTP_SEE_OTHER);
    }
   

}
