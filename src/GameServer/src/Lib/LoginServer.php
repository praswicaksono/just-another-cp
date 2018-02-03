<?php
declare(strict_types=1);

namespace GameServer\Lib;

/**
 * Class LoginServer
 * @package GameServer\Lib
 */
final class LoginServer extends AbstractGameServer
{
    use GetPortAddressTrait;

    /**
     * LoginServer constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
