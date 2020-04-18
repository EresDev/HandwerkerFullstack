<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\RegisterUserCommand;
use App\Application\CommandHandler\RegisterUserHandler;
use App\Domain\Exception\ValidationException;
use App\Domain\ValueObject\Uuid;
use App\Infrastructure\Service\Form\Symfony\LoginFormType;
use App\Infrastructure\Service\Form\Symfony\RegisterFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class RegisterUserController extends AbstractController
{
    private Request $request;
    private RegisterUserHandler $handler;
    private FormFactoryInterface $formFactory;
    private RouterInterface $router;

    public function __construct(
        RequestStack $requestStack,
        RegisterUserHandler $handler,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->handler = $handler;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function handleRequest(): Response
    {
        $uuid = Uuid::create();
        $submittedForm = $this->request->request->get('register_form', []);
        $email = $submittedForm['email'];
        $command = new RegisterUserCommand(
            $uuid,
            $email,
            $submittedForm['password']
        );

        try {
            $this->handler->handle($command);
        } catch (ValidationException $exception) {
            $loginForm = $this->formFactory->createBuilder(LoginFormType::class, null)
                ->setAction($this->router->generate('login'))
                ->getForm();

            $registerForm = $this->formFactory->createBuilder(RegisterFormType::class, null)
                ->setAction($this->router->generate('createUser'))
                ->getForm();

            $violations = $exception->getViolations();

            foreach ($violations as $violation) {
                $registerForm->addError(new FormError($violation));
            }

            return $this->render(
                'login.html.twig',
                [
                    'loginForm' => $loginForm->createView(),
                    'registerForm' => $registerForm->createView()
                ],
                new Response('', 422)
            );
        }

        return $this->render(
            'register.success.html.twig',
            ['successMessage' => 'register.user.success.message'],
            new Response('', 201)
        );
    }
}
