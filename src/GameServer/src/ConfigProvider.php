<?php

namespace GameServer;
use GameServer\Container\Lib\CharServerFactory;
use GameServer\Container\Lib\GameServerStatusFactory;
use GameServer\Container\Lib\LoginServerFactory;
use GameServer\Container\Lib\MapServerFactory;
use GameServer\Lib\CharServer;
use GameServer\Lib\GameServerStatusInterface;
use GameServer\Lib\LoginServer;
use GameServer\Lib\MapServer;

/**
 * The configuration provider for the GameServer module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
            ],
            'factories'  => [
                MapServer::class    => MapServerFactory::class,
                LoginServer::class  => LoginServerFactory::class,
                CharServer::class   => CharServerFactory::class,
                GameServerStatusInterface::class => GameServerStatusFactory::class,
            ],
        ];
    }
}
