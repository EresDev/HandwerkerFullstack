<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\RegisterUserCommand;
use App\Application\CommandHandler\RegisterUserHandler;
use App\Domain\Exception\ValidationException;
use App\Domain\ValueObject\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserController extends AbstractController
{
    private Request $request;
    private RegisterUserHandler $handler;

    public function __construct(
        RequestStack $requestStack,
        RegisterUserHandler $handler
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->handler = $handler;
    }

    public function handleRequest(): Response
    {
        $uuid = Uuid::create();
        $email = $this->request->get('email', '');
        $command = new RegisterUserCommand(
            $uuid,
            $email,
            $this->request->get('password', '')
        );

        try {
            $this->handler->handle($command);
        } catch (ValidationException $exception) {
            return $this->render(
                'login.html.twig',
                ['violations' => $exception->getViolations()],
                new Response('', 422)
            );
        }

        return $this->render(
            'home.html.twig',
            ['uuid' => $uuid->getValue(), 'email' => $email],
            new Response('', 201)
        );
    }
}
