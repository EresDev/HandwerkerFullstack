<?php

declare(strict_types=1);

namespace App\Tests\End2End\Infrastructure\Controller;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use Symfony\Component\Panther\PantherTestCase;

class RegisterUserControllerFrontendTest extends PantherTestCase
{
    public function testPasswordAndConfirmPasswordFieldInvalidWhenDifferent(): void
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/login');

        $client->wait()->until( function($client){
            return $client->executeScript(
                    'return document.readyState;'
                ) == 'complete'; }
        );

        $this->assertPageTitleContains('Login');

        $form = $crawler->filter('form[name=register_form]')->form();
        $form->setValues(
            [
                'register_form[email]' => 'test@eresdev.com',
                'register_form[password]' => '123456',
                'register_form[confirm_password]' => '123456789'
            ]
        );


        $confirmPassword = $client->findElement(WebDriverBy::id('register_form_confirm_password'));
        $confirmPassword->click();
        $confirmPassword->sendKeys('12345678');

        $confirmPassword->sendKeys(WebDriverKeys::TAB);

        $client->executeScript(
            'var event = new Event("change"); document.getElementById("register_form_confirm_password").dispatchEvent(event);'
        );

        $client->executeScript(
            'console.error("test test test");'
        );

        var_dump( $client->manage()->getLog( 'browser' ) );
        echo "Let us see this";

        $confirmPasswordFieldValidity = $client->executeScript(
            'return document.getElementById("register_form_confirm_password").validity.valid;'
        );
        $this->assertFalse(
            $confirmPasswordFieldValidity,
            'Confirm password field is valid, but it should not be because ' .
            'password and confirm password field values are different.'
        );


    }

    public function testPasswordAndConfirmPasswordFieldValidWhenSame(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/login');

        $this->assertPageTitleContains('Login');

        $confirmPasswordFieldValidity = $client->executeScript(
            'return document.getElementById(\'register_form_confirm_password\').validity.valid;'
        );
        $this->assertFalse($confirmPasswordFieldValidity);

        $form = $crawler->filter('form[name=register_form]')->form();
        $form->setValues(
            [
                'register_form[email]' => 'test@eresdev.com',
                'register_form[password]' => '1234567',
                'register_form[confirm_password]' => '1234567'
            ]
        );

        $confirmPasswordFieldValidity = $client->executeScript(
            'return document.getElementById("register_form_confirm_password").validity.valid;'
        );
        $this->assertTrue($confirmPasswordFieldValidity);
    }
}