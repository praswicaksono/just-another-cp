<?php
declare(strict_types=1);

namespace WebUser\Container\Lib\Auth;

use Psr\Container\ContainerInterface;
use WebUser\Lib\Auth\AuthInterface;
use WebUser\Lib\Auth\DefaultAuthenticator;

/**
 * Class AuthFactory
 * @package WebUser\Container\Lib\Auth
 */
final class AuthFactory
{
    /**
     * @param ContainerInterface $container
     * @return AuthInterface
     */
    public function __invoke(ContainerInterface $container) : AuthInterface
    {
        return new DefaultAuthenticator();
    }
}
