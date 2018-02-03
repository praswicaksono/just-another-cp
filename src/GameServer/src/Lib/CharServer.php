<?php
declare(strict_types=1);


namespace GameServer\Lib;

/**
 * Class CharServerMap
 * @package GameServer\Lib
 */
final class CharServer extends AbstractGameServer
{
    use GetPortAddressTrait;

    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
