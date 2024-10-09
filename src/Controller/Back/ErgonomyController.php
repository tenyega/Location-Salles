<?php

namespace App\Controller\Back;

use App\Form\ErgonomyType;
use App\Entity\Ergonomy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/ergonomy")
 */
class ErgonomyController extends AbstractController
{
        
    /**
     * @Route("/ergonomyShow", name="back_ergonomy_ergonomyShow", methods={"GET"})
     */
    public function ergonomyShow(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Ergonomy ::class);
        $ergonomys= $repository->findAll();
        return $this->render('back/ergonomy/ergonomyShow.html.twig', [
            'ergonomys' => $ergonomys,
        ]);
    }

    /**
     * @Route("/newErgonomy", name="back_ergonomy_newErgonomy", methods={"GET", "POST"})
     */
    public function newErgonomy(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ergonomy = new Ergonomy();
        $form = $this->createForm(ErgonomyType::class, $ergonomy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ergonomy);
            $entityManager->flush();

            return $this->redirectToRoute('back_ergonomy_ergonomyShow', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/ergonomy/newErgonomy.html.twig', [
            'ergonomy' => $ergonomy,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/editErgonomy", name="back_ergonomy_editErgonomy", methods={"GET", "POST"})
     */
    public function editErgonomy(Request $request, Ergonomy $ergonomy, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ErgonomyType::class, $ergonomy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('back_ergonomy_ergonomyShow', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/ergonomy/editErgonomy.html.twig', [
            'ergonomy' => $ergonomy,
            'form' => $form,
        ]);
    }
    
    /**
     * @Route("/{id}/deleteErgonomy", name="back_ergonomy_deleteErgonomy", methods={"POST"})
     */
    public function deleteErgonomy(Request $request, Ergonomy $ergonomy, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ergonomy->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ergonomy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_ergonomy_ergonomyShow', [], Response::HTTP_SEE_OTHER);
    }
}
