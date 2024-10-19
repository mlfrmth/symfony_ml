<?php

namespace App\Form\User;

use App\Entity\User;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\{
    AbstractType,
    FormBuilderInterface
};
use Symfony\Component\Form\Extension\Core\Type\{PasswordType, EmailType, RepeatedType};
use Symfony\Component\Validator\Constraints\{Email, NotBlank, Length};

final class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ],
                'attr' => ['placeholder' => '@']
            ])
            ->add('password', RepeatedType::class, [
                'constraints' => [
                    new NotBlank(),
                    // new PasswordStrength(),
                    new Length([
                        'min' => 6,
                        'max' => 48,
                        'minMessage' => 'Your password must be at least {{ limit }} characters long.',
                        'maxMessage' => 'Your password cannot be longer than {{ limit }} characters.',
                    ]),
                ],
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Password', 'hash_property_path' => 'password'],
                'second_options' => ['label' => 'Password (Repeat)'],
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
