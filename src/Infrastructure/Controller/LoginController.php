<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Infrastructure\Service\Form\Symfony\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class LoginController extends AbstractController
{
    private FormFactoryInterface $formFactory;
    private Environment $environment;
    private RouterInterface $router;

    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $environment,
        RouterInterface $router
    ) {
        $this->formFactory = $formFactory;
        $this->environment = $environment;
        $this->router = $router;
    }

    public function handleRequest(): Response
    {
        $loginForm = $this->formFactory->createBuilder(LoginFormType::class, null)
            ->setAction($this->router->generate('api_login_check'))
            ->getForm();

        $content = $this->environment->render(
            'login.html.twig',
            ['loginForm' => $loginForm->createView()]
        );

        return new Response($content);
    }
}
