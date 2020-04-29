<?php

declare(strict_types=1);

namespace App\Tests\End2End\Infrastructure\Controller;

use Symfony\Component\Panther\PantherTestCase;

class RegisterUserControllerFrontendTest extends PantherTestCase
{
    public function testPasswordAndConfirmPasswordFieldValidWhenSame(): void
    {
        //PantherTestCase::startWebServer();
        $client =  static::createPantherClient(
            ['hostname' => 'https://handwerkerfullstack.loc']
        );
        $crawler = $client->request('GET', '/login');

//        $form = $crawler->filter('form[name=register_form]')->form();
//        $form->setValues([
//            'register_form' => [
//                'password' => '123456',
//                'confirm_password' => '123456789'
//            ]
//        ]);

        // Use any PHPUnit assertion, including the ones provided by Symfony
        $this->assertPageTitleContains('Login');
        //$this->assertSelectorTextContains('#main', 'My body');
    }
}