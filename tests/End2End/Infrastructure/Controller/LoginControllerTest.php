<?php

declare(strict_types=1);

namespace App\Tests\End2End\Infrastructure\Controller;

use App\Tests\Shared\Assert;
use App\Tests\Shared\Fixture\UserFixture;
use App\Tests\Shared\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Component\Routing\RouterInterface;

class LoginControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;
    private RouterInterface $router;
    private const URI = ['en' => 'login', 'de' => 'einloggen'];

    protected function setUp(): void
    {
        parent::setUp();
        $this->router = $this->getService(RouterInterface::class);
    }

    /**
     * @dataProvider uriProvider
     */
    public function testSuccessfulLogin(string $uri): void
    {
        $crawler = $this->client->request('get', $uri);
        $form = $crawler->html();
        $form = $crawler->filter('form[name=login_form]')->form();
        $values = $form->getPhpValues();
        $values['login_form']['email'] = UserFixture::EMAIL;
        $values['login_form']['password'] = UserFixture::PLAIN_PASSWORD;
        $form->setValues($values);

        $this->client->submit($form);

        $this->assertResponseRedirects(
            $this->router->generate('loginSuccess'),
            302
        );

        Assert::assertHasCookie(
            $this->client,
            'Authorization',
            'Failed asserting that cookie for Authorization is present.'
        );
    }

    public function uriProvider(): array
    {
        return [
            [self::URI['en']],
            [self::URI['de']]
        ];
    }

    /**
     * @dataProvider uriProvider
     */
    public function testHttpRedirectToHttps(string $uri): void
    {
        $this->makeClientForHttp();
        $this->client->request('get', $uri);

        Assert::assertEquals(301, $this->response()->getStatusCode());
    }

    /**
     * @dataProvider errorMessagesProvider
     */
    public function testLoginFailureForInvalidCredentials(string $uri, string $expectedError): void
    {
        $crawler = $this->client->request('get', $uri);

        $form = $crawler->filter('form[name=login_form]')->form();
        $values = $form->getPhpValues();
        $values['login_form']['email'] = 'someEmail@eresdev.com';
        $values['login_form']['password'] = UserFixture::PLAIN_PASSWORD;
        $form->setValues($values);

        $postSubmitCrawler = $this->client->submit($form);

        $this->assertEquals(
            $this->response()->getStatusCode(),
            401
        );

        $errors = $postSubmitCrawler
            ->filter('form[name=login_form] ul.formErrors')
            ->children();

        $this->assertEquals(1, count($errors));
        $this->assertEquals($expectedError, $errors->first()->text());
    }

    public function errorMessagesProvider(): array
    {
        $uris = $this->uriProvider();
        $uris[0][] = 'Login credentials are not valid.';
        $uris[1][] = 'Anmeldeinformationen sind ungültig.';

        return $uris;
    }
}
