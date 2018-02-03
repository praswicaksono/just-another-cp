<?php
declare(strict_types=1);

namespace WebUser\Lib\Auth;

/**
 * Interface AuthInterface
 * @package WebUser\Lib\Auth
 */
interface AuthInterface
{
    /**
     * @param string $rawPassword
     * @param string $encryptedPassword
     * @return bool
     */
    public function authenticate(string $rawPassword, string $encryptedPassword) : bool;

    /**
     * @param string $password
     * @return string
     */
    public function hash(string $password) : string;
}
