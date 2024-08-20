<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    "label" => "E-Mail",
                    "required" => true,
                    "constraints" => [
                        new NotBlank(["message" => "Veuillez renseigner votre adresse mail"]),
                    ]
                ]
            )
            ->add(
                'firstname',
                TextType::class,
                [
                    "label" => "Prénom",
                    "required" => true,
                    "constraints" => [
                        new NotBlank(["message" => "Veuillez renseigner votre prénom"]),
                        new Length(["max" => 50, "maxMessage" => "Votre prénom doit faire moins de 50 caractères"])
                    ]
                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    "label" => "Nom",
                    "required" => true,
                    "constraints" => [
                        new NotBlank(["message" => "Veuillez renseigner votre nom"]),
                        new Length(["max" => 50, "maxMessage" => "Votre nom doit faire moins de 50 caractères"])
                    ]
                ]
            )
            ->add("password", PasswordType::class,
                ["label" => "Mot de passe",
                    "required" => true,
                    "constraints" => [
                        new NotBlank(["message" => "Veuillez renseigner un mot de passe"]),
                    ]])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn btn-outline-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
