<?php
declare(strict_types=1);

namespace GameServer\Lib;

/**
 * Class MapServer
 * @package GameServer\Lib
 */
final class MapServer extends AbstractGameServer
{
    use GetPortAddressTrait;

    /**
     * MapServer constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
