<?php

namespace App\Controller;

use App\Entity\UserInformations;
use App\Form\CrudformType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(ManagerRegistry $doctrine): Response
    {

    }

    #[Route('/', name: 'create')]

    public function create(Request $request, ManagerRegistry $doctrine){
        $usrinfo = new UserInformations();
        $form = $this->createForm(CrudformType::class, $usrinfo); //pass form class and entity type
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $doctrine->getManager();
            // $form->getData() holds the submitted values
            // but, the original `$usrinfo` variable has also been updated
            $usrinfo = $form->getData();

                   // tell Doctrine you want to (eventually) save the userinfo (no queries yet)
            $entityManager->persist($usrinfo);

        // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            $this->addFlash('notice','Submitted Successfully!!');

        }

         //fetching data
        $repository = $doctrine->getRepository(UserInformations::class);
        $userinfo = $repository->findAll();

        return $this->render('/main/createform.html.twig',[

            'form' => $form->createView(),
            'list' => $userinfo

        ]);
        


    }


     /**
     * @Route("/update/{id}",name="update")
     */   

     public function update(Request $request, ManagerRegistry $doctrine, $id)
     {
        $entityManager = $doctrine->getManager();
        $usrinfo = $entityManager->getRepository(UserInformations::class)->find($id);
        $form = $this->createForm(CrudformType::class, $usrinfo); //pass form class and entity type
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $doctrine->getManager();
            // $form->getData() holds the submitted values
            // but, the original `$usrinfo` variable has also been updated
            $usrinfo = $form->getData();

                   // tell Doctrine you want to (eventually) save the userinfo (no queries yet)
            $entityManager->persist($usrinfo);

        // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            $this->addFlash('notice','Updated Successfully!!');

            return $this->redirectToRoute('create');
        }

        return $this->render('/main/update.html.twig',[

            'form' => $form->createView(),

        ]);

     }

    /**
     * @Route("/delete/{id}",name="delete")
     */   

     public function delete(Request $request, ManagerRegistry $doctrine, $id){
        //stuff
        $entityManager = $doctrine->getManager();
        $usrinfo = $entityManager->getRepository(UserInformations::class)->find($id);
        
        $entityManager->remove($usrinfo);
        $entityManager->flush();

        $this->addFlash('notice','Deleted Successfully!!');
        return $this->redirectToRoute('create');



     }
}
