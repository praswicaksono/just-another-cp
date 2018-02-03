<?php
declare(strict_types=1);


namespace GameServer\Container\Lib;

use GameServer\Lib\CharServer;
use Psr\Container\ContainerInterface;

/**
 * Class CharServerFactory
 * @package GameServer\Container\Lib
 */
final class CharServerFactory
{
    /**
     * @param ContainerInterface $container
     * @return CharServer
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        return new CharServer($container->get('config')['char-server']);
    }
}
