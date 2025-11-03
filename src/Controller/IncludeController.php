<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Src\Form\Type\SearchFormType;


#[Route('/include')]
class IncludeController extends AbstractController
{
    #[Route('/search-form', name: 'app_include_search_form', methods: ['GET', 'POST'])]
    public function searchForm(Request $request): Response
    {
        $form = $this->createForm(SearchFormType::class, null, [
            'action' => $this->generateUrl('app_include_search_form'),
            'method' => 'POST',
        ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            // Detect if we're on artist or track page from referer
            $referer = $request->headers->get('referer');
            $routeName = 'search_tracks'; // default
            
            if ($referer && str_contains($referer, '/artist')) {
                $routeName = 'search_artists';
            }
            
            return $this->redirectToRoute($routeName, ['search' => $data['query']]);
        }

        return $this->render('include/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}