<?php

namespace App\Controller\Back;

use App\Entity\Material;
use App\Form\MaterialType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/material")
 */
class MaterialController extends AbstractController
{

    /**
     * @Route("/materialShow", name="back_material_materialShow", methods={"GET"})
     */
    public function materialShow(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Material ::class);
        $materials= $repository->findAll();
        return $this->render('back/material/materialShow.html.twig', [
            'materials' => $materials,
        ]);
    }

     /**
     * @Route("/newMaterial", name="back_material_newMaterial", methods={"GET", "POST"})
     */
    public function newMaterial(Request $request, EntityManagerInterface $entityManager): Response
    {
        $material = new Material();
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($material);
            $entityManager->flush();

            return $this->redirectToRoute('back_material_materialShow', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/material/newMaterial.html.twig', [
            'material' => $material,
            'form' => $form,
        ]);
    }

      /**
     * @Route("/{id}/editMaterial", name="back_material_editMaterial", methods={"GET", "POST"})
     */
    public function editmaterial(Request $request, Material $material, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('back_material_materialShow', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/material/editMaterial.html.twig', [
            'material' => $material,
            'form' => $form,
        ]);
    }
    
     /**
     * @Route("/{id}/deleteMaterial", name="back_material_deleteMaterial", methods={"POST"})
     */
    public function deleteMaterial(Request $request, Material $material, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$material->getId(), $request->request->get('_token'))) {
            $entityManager->remove($material);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_material_materialShow', [], Response::HTTP_SEE_OTHER);
    }
}
