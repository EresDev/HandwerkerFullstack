<?php

declare(strict_types=1);

namespace App\Tests\End2End\Infrastructure\Controller;

use App\Tests\Shared\Fixture\UserFixture;
use App\Tests\Shared\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\Routing\RouterInterface;

class RegisterUserControllerTest extends WebTestCase
{
    use ReloadDatabaseTrait;
    private RouterInterface $router;
    private const URI = ['en' => 'login', 'de' => 'einloggen'];

    protected function setUp(): void
    {
        parent::setUp();
        $this->router = $this->getService(RouterInterface::class);
    }

    /**
     * @dataProvider uriWithSuccessMessageProvider
     */
    public function testSuccessfulUserRegistration(
        string $registerUri,
        string $successMessage
    ): void {
        $crawler = $this->client->request('get', $registerUri);

        $form = $crawler->filter('form[name=register_form]')->form();
        $values = $form->getPhpValues();
        $values['register_form']['email'] = 'testUserRegisteration@eresdev.com';
        $values['register_form']['password'] = UserFixture::PLAIN_PASSWORD;
        $values['register_form']['confirm_password'] = $values['register_form']['password'];
        $form->setValues($values);

        $successCrawler = $this->client->submit($form);

        $this->assertEquals(
            $this->response()->getStatusCode(),
            201
        );

        $this->assertEquals(
            $successMessage,
            $successCrawler->filter('#main div.success h1')->text()
        );
    }

    public function uriWithSuccessMessageProvider(): array
    {
        $uris = $this->uriProvider();
        $uris[0][] = 'Your account has been created successfully. You can login now.';
        $uris[1][] = 'Ihr Konto wurde erfolgreich erstellt. Sie können sich jetzt anmelden.';

        return $uris;
    }

    public function uriProvider(): array
    {
        return [
            [self::URI['en']],
            [self::URI['de']]
        ];
    }


    /**
     * @dataProvider uriWithErrorsForInvalidEmail
     */
    public function testRegistrationErrorForInvalidEmail(
        string $registerUri,
        string $expectedError
    ): void {
        $crawler = $this->client->request('get', $registerUri);

        $form = $crawler->filter('form[name=register_form]')->form();
        $values = $form->getPhpValues();
        $values['register_form']['email'] = 'testUserRegisteration';
        $values['register_form']['password'] = UserFixture::PLAIN_PASSWORD;
        $values['register_form']['confirm_password'] = $values['register_form']['password'];
        $form->setValues($values);

        $postSubmitCrawler = $this->client->submit($form);

        $this->assertEquals(
            $this->response()->getStatusCode(),
            422
        );

        $errors = $postSubmitCrawler
            ->filter('form[name=register_form] ul.formErrors')
            ->children();

        $this->assertEquals(1, count($errors));
        $this->assertEquals($expectedError, $errors->first()->text());
    }

    public function uriWithErrorsForInvalidEmail(): array
    {
        $uris = $this->uriProvider();
        $uris[0][] = 'Email is not valid.';
        $uris[1][] = 'E-Mail ist ungültig.';

        return $uris;
    }

    /**
     * @dataProvider uriWithErrorsForInvalidEmailAndInvalidPassword
     */
    public function testRegistrationErrorForInvalidEmailAndInvalidPassword(
        string $registerUri,
        string $emailError,
        string $passwordError
    ): void {
        $crawler = $this->client->request('get', $registerUri);

        $form = $crawler->filter('form[name=register_form]')->form();
        $values = $form->getPhpValues();
        $values['register_form']['email'] = 'testUserRegisteration';
        $values['register_form']['password'] = 'short';
        $values['register_form']['confirm_password'] = $values['register_form']['password'];
        $form->setValues($values);

        $postSubmitCrawler = $this->client->submit($form);

        $this->assertEquals(
            $this->response()->getStatusCode(),
            422
        );

        $errors = $postSubmitCrawler
            ->filter('form[name=register_form] ul.formErrors')
            ->children();

        $this->assertEquals(2, count($errors));
        $this->assertEquals($emailError, $errors->eq(0)->text());
        $this->assertEquals($passwordError, $errors->eq(1)->text());
    }

    public function uriWithErrorsForInvalidEmailAndInvalidPassword(): array
    {
        $uris = $this->uriProvider();
        $uris[0][] = 'Email is not valid.';
        $uris[0][] = 'Password cannot be less than 6 characters.';

        $uris[1][] = 'E-Mail ist ungültig.';
        $uris[1][] = 'Das Passwort darf nicht weniger als 6 Zeichen enthalten.';

        return $uris;
    }
}
