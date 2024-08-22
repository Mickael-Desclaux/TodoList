<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use App\Entity\Status;
use App\Entity\Priority;
use App\Repository\PriorityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TaskType extends AbstractType
{    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['is_edit'] === false) {
            $builder
            ->add(
                'priority',
                EntityType::class,
                [
                    "class" => Priority::class,
                    "label" => "Priorité",
                    "choice_label" => "name"
                ]
            )
            ->add(
                'limitDate',
                DateType::class,
                [
                    "widget" => "single_text",
                    "label" => "Date Limite"
                ]
                );
        };
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
                TextareaType::class,
                [
                    "label" => "Description",
                    "constraints" => [
                        new Length(["max" => 1000, "maxMessage" => "La description ne doit pas dépasser 1000 caractères"])
                    ]
                ]
            )
            ->add(
                'status',
                EntityType::class,
                [
                    "class" => Status::class,
                    "label" => "Statut",
                    "choice_label" => "name"
                ]
            )
            ->add("assignedUsers", EntityType::class, [
                "class" => User::class,
                "label" => "Assignation",
                "choice_label" => function (User $user) {
                    return $user->getFirstname() . ' ' . $user->getLastname();
                },
                "autocomplete" => true,
                "multiple" => true,
                "expanded" => false
            ])
            // TODO: Add multiple categories to a task
            // ->add('categories', CollectionType::class, [
            //     'entry_type' => CategoryType::class,
            //     'allow_add' => true,
            //     'allow_delete' => true,
            //     'by_reference' => false,
            //     'label' => true
            // ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn btn-outline-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'is_edit' => false,
        ]);
    }
}
