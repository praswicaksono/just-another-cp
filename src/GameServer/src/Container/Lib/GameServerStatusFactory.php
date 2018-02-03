<?php
declare(strict_types=1);


namespace GameServer\Container\Lib;

use GameServer\Lib\CharServer;
use GameServer\Lib\GameServerStatus;
use GameServer\Lib\LoginServer;
use GameServer\Lib\MapServer;
use Psr\Container\ContainerInterface;

/**
 * Class GameServerStatusFactory
 * @package GameServer\Container\Lib
 */
final class GameServerStatusFactory
{
    /**
     * @param ContainerInterface $container
     * @return GameServerStatus
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container) : GameServerStatus
    {
        return new GameServerStatus(
            $container->get(MapServer::class),
            $container->get(CharServer::class),
            $container->get(LoginServer::class)
        );
    }
}
