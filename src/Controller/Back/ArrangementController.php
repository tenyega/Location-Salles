<?php

namespace App\Controller\Back;

use App\Entity\Arrangement;
use App\Form\ArrangementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/arrangement")
 */
class ArrangementController extends AbstractController
{
     /**
     * @Route("/arrangementShow", name="back_arrangement_arrangementShow", methods={"GET"})
     */
    public function arrangementShow(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Arrangement ::class);
        $arrangements= $repository->findAll();

        return $this->render('back/arrangement/arrangementShow.html.twig', [
            'arrangements' => $arrangements,
        ]);
    }

     /**
     * @Route("/newArrangement", name="back_arrangement_newArrangement", methods={"GET", "POST"})
     */
    public function newArrangement(Request $request, EntityManagerInterface $entityManager): Response
    {
        $arrangement = new Arrangement();
        $form = $this->createForm(ArrangementType::class, $arrangement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($arrangement);
            $entityManager->flush();

            return $this->redirectToRoute('back_arrangement_arrangementShow', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/arrangement/newArrangement.html.twig', [
            'arrangement' => $arrangement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/editArrangement", name="back_arrangement_editArrangement", methods={"GET", "POST"})
     */
    public function editArrangement(Request $request, Arrangement $arrangement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArrangementType::class, $arrangement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('back_arrangement_arrangementShow', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/arrangement/editArrangement.html.twig', [
            'arrangement' => $arrangement,
            'form' => $form,
        ]);
    }
    
    /**
     * @Route("/{id}/deleteArrangement", name="back_arrangement_deleteArrangement", methods={"POST"})
     */
    public function deleteArrangement(Request $request, Arrangement $Arrangement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$Arrangement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($Arrangement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_arrangement_arrangementShow', [], Response::HTTP_SEE_OTHER);
    }

}
