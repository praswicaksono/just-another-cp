<?php
declare(strict_types=1);

namespace GameServer\Container\Lib;

use GameServer\Lib\MapServer;
use Psr\Container\ContainerInterface;

/**
 * Class MapServerFactory
 * @package GameServer\Container\Lib
 */
final class MapServerFactory
{
    /**
     * @param ContainerInterface $container
     * @return MapServer
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        return new MapServer($container->get('config')['map-server']);
    }
}
