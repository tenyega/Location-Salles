<?php

namespace App\Controller\Front;

use App\Form\SearchFormType;
use App\Repository\HallRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/front/search")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/", name="front_search", methods={"GET","POST"})
     */
  
    public function search(Request $request, HallRepository $hallRepository): Response
    {
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);
        $halls= [];
        if ($form->isSubmitted() && $form->isValid()) {
            $data=$form->getData();
            $halls= $hallRepository->findByCriteria($data);
            if($halls== []){
                return $this->render('front/search/noresult.html.twig');
            }
        } 
        
        return $this->render('front/search/search.html.twig', [
        'datas'=>$halls,
        'form' => $form->createView(),
        ]);
    }

}