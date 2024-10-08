<?php

declare(strict_types=1);

namespace App\Tests\Common\Csrf;

use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class CsrfTokenManagerMock implements CsrfTokenManagerInterface
{
    public const APPLICATION_TEST_CSRF_TOKEN = 'application.test.token';

    public function getToken(string $tokenId): CsrfToken
    {
        return new CsrfToken($tokenId, self::APPLICATION_TEST_CSRF_TOKEN);
    }

    public function refreshToken(string $tokenId): CsrfToken
    {
        return new CsrfToken($tokenId, self::APPLICATION_TEST_CSRF_TOKEN);
    }

    public function removeToken(string $tokenId): ?string
    {
        return null;
    }

    public function isTokenValid(CsrfToken $token): bool
    {
        return $token->getValue() === self::APPLICATION_TEST_CSRF_TOKEN;
    }
}
