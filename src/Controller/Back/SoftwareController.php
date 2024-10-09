<?php

namespace App\Controller\Back;

use App\Entity\Software;
use App\Form\SoftwareType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/back/software")
 */
class SoftwareController extends AbstractController
{    
    /**
     * @Route("/softwareShow", name="back_software_softwareShow", methods={"GET"})
     */
    public function softwareShow(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Software ::class);
        $softwares= $repository->findAll();
        return $this->render('back/software/softwareShow.html.twig', [
            'softwares' => $softwares,
        ]);
    }

     /**
     * @Route("/newSoftware", name="back_software_newSoftware", methods={"GET", "POST"})
     */
    public function newSoftware(Request $request, EntityManagerInterface $entityManager): Response
    {
        $software = new Software();
        $form = $this->createForm(SoftwareType::class, $software);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($software);
            $entityManager->flush();

            return $this->redirectToRoute('back_software_softwareShow', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/software/newSoftware.html.twig', [
            'software' => $software,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/editSoftware", name="back_software_editSoftware", methods={"GET", "POST"})
     */
    public function editSoftware(Request $request, Software $software, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SoftwareType::class, $software);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('back_software_softwareShow', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/software/editSoftware.html.twig', [
            'software' => $software,
            'form' => $form,
        ]);
    }
    
    /**
     * @Route("/{id}/deleteSoftware", name="back_software_deleteSoftware", methods={"POST"})
     */
    public function deleteSoftware(Request $request, Software $software, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$software->getId(), $request->request->get('_token'))) {
            $entityManager->remove($software);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_software_softwareShow', [], Response::HTTP_SEE_OTHER);
    }
}
