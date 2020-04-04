<?php

declare(strict_types=1);

namespace App\Tests\Integration\Bundle\LexikJWTAuthenticationBundle;

use App\Kernel;
use App\Infrastructure\Security\Symfony\PasswordEncoder;
use App\Tests\Shared\Fixture\UserFixture;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;

class JWTTokenGenerationTest extends KernelTestCase
{
    private $request;

    use RefreshDatabaseTrait;

    protected function setUp() : void
    {
        parent::setUp();
        self::bootKernel();
    }

    public function testTokenGenerationForExistingUser() : void
    {
        $this->request = Request::create(
            '/login_check',
            'POST',
            [
                'login_form' => [
                    'email' => UserFixture::EMAIL,
                    'password' => UserFixture::PLAIN_PASSWORD
                ]
            ],
            [],
            [],
            ['HTTPS' => true]
        );

        $kernel = self::$kernel;
        $response = $kernel->handle($this->request);

        $this->assertEquals(
            302,
            $response->getStatusCode(),
            'JWT login check, to receive token failed. Got invalid http status code.'
        );

        $tokenCookie = $response->headers->all()['set-cookie'][0];
        $this->assertTrue(
            0 === strpos($tokenCookie, 'Authorization'),
            "No token received. The content received: \n" .
            $response->getContent()
        );
    }

    public function testTokenGenerationErrorNonExistingUser() : void
    {
        $this->request = Request::create(
            '/login_check',
            'POST',
            [
                'login_form' => [
                    'email' => 'userShouldNotExistInDB@eresdev.com',
                    'password' => 'somePassword1145236'
                ]
            ],
            [],
            [],
            ['HTTPS' => true]
        );

        $kernel = new Kernel('test', true);
        $response = $kernel->handle($this->request);

        $this->assertEquals(401, $response->getStatusCode());
    }
}
