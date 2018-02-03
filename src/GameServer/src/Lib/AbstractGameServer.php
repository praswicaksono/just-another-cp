<?php
declare(strict_types=1);


namespace GameServer\Lib;

/**
 * Class AbstractGameServer
 * @package GameServer\Lib
 */
abstract class AbstractGameServer
{
    /**
     * @return bool
     */
    public function isUp() : bool
    {
        $sock = @fsockopen($this->getAddress(), $this->getPort(),$errno,$errstr, $this->getTimeout());

        if (is_resource($sock)) {
            fclose($sock);
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    abstract public function getAddress() : string;

    /**
     * @return int
     */
    abstract public function getPort() : int;

    /**
     * @return int
     */
    abstract public function getTimeout() : int;
}
