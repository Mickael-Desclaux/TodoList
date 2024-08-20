<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use App\Entity\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    "label" => "Titre",
                    "required" => true,
                    "constraints" => [
                        new NotBlank(["message" => "Veuillez renseigner un titre"]),
                        new Length(["max" => 50, "maxMessage" => "Le titre de la tâche doit contenir moins de 50 caractères"])
                    ]
                ]
            )
            ->add(
                'description',
                TextType::class,
                [
                    "label" => "Description",
                    "constraints" => [
                        new Length(["max" => 1000, "maxMessage" => "La description ne doit pas dépasser 1000 caractères"])
                    ]
                ]
            )
            ->add(
                'priorityId',
                ChoiceType::class,
                [
                    "label" => "Priorité",
                    "choices" => [
                        "Basse" => 1,
                        "Moyenne" => 2,
                        "Haute" => 3
                    ]
                ]
            )
            ->add(
                'limitDate',
                DateType::class,
                [
                    "widget" => "single_text"
                ]
            )
            ->add("categories", CollectionType::class, [
                "entry_type" => CategoryType::class,
                "entry_options" => ["label" => false],
                "allow_add" => true,
                "by_reference" => false,
            ])
            ->add('status', EntityType::class, 
            [
                "class" => Status::class,
                "label" => "Statut",
                "choice_label" => "name"
            ])
            ->add("assignedUsers", EntityType::class, [
                "class" => User::class,
                "choice_label" => function (User $user) {
                    return $user->getFirstname() . ' ' . $user->getLastname();
                },
                "multiple" => true,
                "expanded" => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn btn-outline-primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
