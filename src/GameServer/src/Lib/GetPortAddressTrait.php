<?php
declare(strict_types=1);


namespace GameServer\Lib;

/**
 * Trait GetPortAddressTrait
 * @package GameServer\Lib
 */
trait GetPortAddressTrait
{
    /**
     * @var array
     */
    private $config;

    /**
     * @return int
     */
    public function getPort() : int
    {
        return (int) $this->config['port'];
    }

    /**
     * @return string
     */
    public function getAddress() : string
    {
        return (string) $this->config['address'];
    }

    /**
     * @return int
     */
    public function getTimeOut() : int
    {
        return (int) $this->config['timeout'];
    }
}