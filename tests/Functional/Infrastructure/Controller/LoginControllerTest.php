<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Controller;

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
    }

    public function uriProvider(): array
    {
        return [
            [self::URI['en']],
            [self::URI['de']]
        ];
    }
}
