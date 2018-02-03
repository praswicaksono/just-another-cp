<?php
declare(strict_types=1);

namespace WebUser\Lib\Auth;

/**
 * Class DefaultAuthenticator
 * @package WebUser\Lib\Auth
 */
final class DefaultAuthenticator implements AuthInterface
{
    /**
     * @param string $rawPassword
     * @param string $encryptedPassword
     * @return bool
     */
    public function authenticate(string $rawPassword, string $encryptedPassword): bool
    {
        return password_verify($rawPassword, $encryptedPassword);
    }

    /**
     * @param string $password
     * @return string
     */
    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2_DEFAULT_TIME_COST);
    }
}
