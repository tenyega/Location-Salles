<?php

namespace App\Controller\Back;


use App\Form\SearchFormType;
use App\Repository\HallRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/search")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/", name="back_search", methods={"GET","POST"})
     * Search Function;
     * The data of the form entered by the user is collected with the $form->getData()
     * and hall repository is used to access the function findbyCriteria($data) if the result returns null means that 
     * theres no hall that corresponds to the users search data and it redirects to the result page which affiches the error msg
     * 
     *if the data is collected from the function findbyCriteria($data) its passed to the same page of the search.
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
              return $this->render('back/search/noresult.html.twig');
          }
        } 
          return $this->render('back/search/search.html.twig', [
            'datas'=>$halls,
            'form' => $form->createView(),
        ]);
    }

}