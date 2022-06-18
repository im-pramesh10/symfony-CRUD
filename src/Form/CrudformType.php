<?php

namespace App\Form;

use App\Entity\UserInformations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrudformType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, ['attr'=> array('placeholder'=>'Name', 'class'=>'form-control')])
            ->add('contact', NumberType::class,['attr'=>array('placeholder'=>'Number', 'class'=>'form-control')])
            ->add('email', EmailType::class,['attr'=>array('placeholder'=>'email',' class'=>'form-control')])
            ->add('submit',SubmitType::class,['attr'=>array('class'=>'btn btn-info mt-2 text-white')])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserInformations::class,
        ]);
    }
}
