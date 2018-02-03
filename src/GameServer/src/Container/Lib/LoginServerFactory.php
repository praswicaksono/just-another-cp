<?php
declare(strict_types=1);

namespace GameServer\Container\Lib;

use GameServer\Lib\LoginServer;
use Psr\Container\ContainerInterface;

/**
 * Class LoginServerFactory
 * @package GameServer\Container\Lib
 */
final class LoginServerFactory
{
    /**
     * @param ContainerInterface $container
     * @return LoginServer
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        return new LoginServer($container->get('config')['login-server']);
    }
}
