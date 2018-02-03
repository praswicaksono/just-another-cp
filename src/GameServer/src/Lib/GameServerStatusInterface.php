<?php
declare(strict_types=1);

namespace GameServer\Lib;

/**
 * Interface GameServerStatusInterface
 * @package GameServer\Lib
 */
interface GameServerStatusInterface
{
    /**
     * @return bool
     */
    public function isMapServerOnline() : bool;

    /**
     * @return bool
     */
    public function isCharServerOnline() : bool;

    /**
     * @return bool
     */
    public function isLoginServerOnline() : bool;
}
