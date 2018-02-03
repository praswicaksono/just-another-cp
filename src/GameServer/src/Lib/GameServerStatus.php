<?php
declare(strict_types=1);

namespace GameServer\Lib;

/**
 * Class GameServerStatus
 * @package GameServer\Lib
 */
final class GameServerStatus implements GameServerStatusInterface
{
    /**
     * @var MapServer
     */
    private $mapServer;

    /**
     * @var CharServer
     */
    private $charServer;

    /**
     * @var LoginServer
     */
    private $loginServer;

    /**
     * GameServerStatus constructor.
     * @param MapServer $mapServer
     * @param CharServer $charServer
     * @param LoginServer $loginServer
     */
    public function __construct(MapServer $mapServer, CharServer $charServer, LoginServer $loginServer)
    {
        $this->mapServer = $mapServer;
        $this->charServer = $charServer;
        $this->loginServer = $loginServer;
    }

    /**
     * @return bool
     */
    public function isMapServerOnline() : bool
    {
        return $this->mapServer->isUp();
    }

    /**
     * @return bool
     */
    public function isLoginServerOnline() : bool
    {
        return $this->loginServer->isUp();
    }

    /**
     * @return bool
     */
    public function isCharServerOnline() : bool
    {
        return $this->charServer->isUp();
    }
}
