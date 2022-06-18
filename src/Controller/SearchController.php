<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchUserInfoType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\UserInformations;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/search', name:'app_search')]
    public function index(Request $request): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

       //$usrinfo = new UserInformations();
        //$form = $this->createForm(SearchUserInfoType::class, $usrinfo); //pass form class and entity type
       $form = $this->createFormBuilder()
            ->add('id', NumberType::class, ['attr'=> array('placeholder' => 'ID','class'=>'form-control'), 'required' => false])
            ->add('username', TextType::class, ['attr'=> array('placeholder' => 'Username','class'=>'form-control'), 'required' => false])
            ->add('email', EmailType::class, ['attr'=> array('placeholder' => 'email','class'=>'form-control'), 'required' => false])
            ->add('contact' , NumberType::class, ['attr'=> array('placeholder' => 'contact','class'=>'form-control'), 'required' => false])
            ->add('search', SubmitType::class, ['attr'=> array('class'=>'btn btn-info mt-2 text-white')])
            ->getForm();
       $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $userinfo = $form->getData();

                foreach ($userinfo as $key => $value) {
                    if($value == null){
                        unset($userinfo[$key]);
                    }
                }
                $repository = $this->em->getRepository(UserInformations::class);
                $userinfo=$repository->findBy($userinfo);

                 //dd($userinfo);

                //array to store form informations
               // $formData = array(array('username'=>''),array('contact'=>''),array('email'=>null));
                //$userid  = array();
/*
                foreach ($formData as $values)
                {
                    $user=$repository->findBy($values);
                        foreach ($user as $value)
                        {
                            $userid[] = $value->getId();
                        }
                    //array_push($userid,$userid->getId());
                }*/
                
                //dd($userinfo);
                
                return $this->render('search/index.html.twig',[
                    'form' => $form->createView(),
                    'list' => $userinfo
                ]);
      
            }

        else
        {

            return $this->render('search/index.html.twig',[
            'form' => $form->createView(),
            'list' => null
            ]);
        }
    }
}
