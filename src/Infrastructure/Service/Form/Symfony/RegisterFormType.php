<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Form\Symfony;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add(
                'password',
                PasswordType::class,
                ['attr' => ['minlength' => 6, 'maxlength' => 4096]]
            )
            ->add(
                'confirm_password',
                PasswordType::class,
                ['attr' => ['minlength' => 6, 'maxlength' => 4096]]
            )
            ->add('Register', SubmitType::class);
    }
}
