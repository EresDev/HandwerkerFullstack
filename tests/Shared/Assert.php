<?php

namespace App\Tests\Shared;

use PHPUnit\Framework\Assert as PHPUnitAssert;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

abstract class Assert extends PHPUnitAssert
{
    public static function assertHasCookie(
        KernelBrowser $client,
        string $cookieKey,
        string $message = 'Failed asserting that cookie is present'
    ): void
    {
        $cookie = $client->getCookieJar()->get($cookieKey);
        PHPUnitAssert::assertTrue(isset($cookie) && !is_null($cookie), $message);
    }
}
