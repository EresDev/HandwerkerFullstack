<?php

declare(strict_types=1);

namespace App\Infrastructure\Security\Symfony;

use App\Infrastructure\Service\Form\Symfony\LoginFormType;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface as ContractsEventDispatcherInterface;
use Twig\Environment;

class LoginFailureHandler implements AuthenticationFailureHandlerInterface
{
    protected EventDispatcherInterface $dispatcher;
    private FormFactoryInterface $formFactory;
    private Environment $environment;
    private RouterInterface $router;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        FormFactoryInterface $formFactory,
        Environment $environment,
        RouterInterface $router
    )
    {
        $this->dispatcher = $dispatcher;
        $this->formFactory = $formFactory;
        $this->environment = $environment;
        $this->router = $router;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $event = new AuthenticationFailureEvent(
            $exception,
            new JWTAuthenticationFailureResponse($exception->getMessageKey())
        );

        if ($this->dispatcher instanceof ContractsEventDispatcherInterface) {
            $this->dispatcher->dispatch($event, Events::AUTHENTICATION_FAILURE);
        } else {
            $this->dispatcher->dispatch(Events::AUTHENTICATION_FAILURE, $event);
        }


        $loginForm = $this->formFactory->createBuilder(LoginFormType::class, null)
            ->setAction($this->router->generate('api_login_check'))
            ->getForm();

        $loginForm->addError(new FormError('login.failed.invalid.credentials'));

        $content = $this->environment->render(
            'login.html.twig',
            ['loginForm' => $loginForm->createView()]
        );

        return new Response($content, 401);
    }
}
