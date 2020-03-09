<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Service\Security\Security;
use App\Infrastructure\Service\Form\Symfony\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class HomeController extends AbstractController
{
    private FormFactoryInterface $formFactory;
    private Environment $environment;
    private RouterInterface $router;
    private Security $security;

    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $environment,
        RouterInterface $router,
        Security $security
    ) {
        $this->formFactory = $formFactory;
        $this->environment = $environment;
        $this->router = $router;
        $this->security = $security;
    }

    public function handleRequest(): Response
    {
        $loginForm = $this->formFactory->createBuilder(LoginFormType::class, null)
            ->setAction($this->router->generate('api_login_check'))
            ->getForm();

        $content = $this->environment->render('home.html.twig');

        return new Response($content);
    }
}
