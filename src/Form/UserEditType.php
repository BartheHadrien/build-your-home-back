<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('lastname', TextType::class,
            [
                "label" => "Nom :",
                "attr" => ["placeholder" => "saisissez le nom de l'utilisateur ..."]
            ])
            ->add('firstname', TextType::class,
            [
                "label" => "Prénom :",
                "attr" => ["placeholder" => "saisissez le prénom de l'utilisateur ..."]
            ])
            ->add('adress', TextType::class,
            [
                "label" => "Adresse :",
                "attr" => ["placeholder" => "saisissez l'adresse de l'utilisateur ..."]
            ])
            ->add('birthdate', DateType::class, 
            [
                "widget" => "single_text",
                "label" => "Date d'anniversaire :",
                'input'  => 'datetime'
            ])
            ->add('email', EmailType::class,
            [
                "label" => "Email :",
                "attr" => ["placeholder" => "saisissez l'adresse email de l'utilisateur ..."]
            ])
            ->add('roles', ChoiceType::class, [
                "label" => "Choisir le/les rôle/s de l'utilisateur :",
                'choices'  => [
                    'User' => "ROLE_USER",
                    'Admin' => "ROLE_ADMIN"
                ],
                "multiple" => true,
                "expanded" => true
            ])
            // ->add('password', RepeatedType::class, array(
            //     'type' => PasswordType::class,
            //     'first_options'  => array('label' => 'Password'),
            //     'second_options' => array('label' => 'Repeat Password'),
            // ))
            ->add('phone', TextType::class,
            [
                "label" => "Numero de téléphone :",
                "attr" => ["placeholder" => "saisissez le numéro de téléphone de l'utilisateur ..."]
            ])
            // ->add('createdAt', HiddenType::class)
            // ->add('updatedAt')
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
