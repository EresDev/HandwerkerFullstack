<?php

declare(strict_types=1);

namespace App\Tests\End2End\Infrastructure\Controller;

use Symfony\Component\Panther\PantherTestCase;

class RegisterUserControllerFrontendTest extends PantherTestCase
{
    public function testPasswordAndConfirmPasswordFieldValidWhenSame(): void
    {
        //PantherTestCase::startWebServer();
        $client =  static::createPantherClient();
        $crawler = $client->request('GET', '/login');
//        $html = $crawler->html();
        //$form = $crawler->filter('form[name=register_form]')->form();
//        $form->setValues([
//            'register_form' => [
//                'password' => '123456',
//                'confirm_password' => '123456789'
//            ]
//        ]);



        $url = 'https://handwerkerfullstack.loc/login';

        $file =  file_get_contents($url);

        // Use any PHPUnit assertion, including the ones provided by Symfony
        $this->assertPageTitleContains('Login');
        //$this->assertSelectorTextContains('#main', 'My body');

        $this->assertTrue(true);
    }
}