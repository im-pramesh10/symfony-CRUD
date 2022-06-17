<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchUserInfoType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\UserInformations;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {

        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $usrinfo = new UserInformations();
        $form = $this->createForm(SearchUserInfoType::class, $usrinfo); //pass form class and entity type
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $repository = $doctrine->getRepository(UserInformations::class);
            $userinfo = $repository->find($form->get('id')->getData());


        }

        

        return $this->render('search/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
