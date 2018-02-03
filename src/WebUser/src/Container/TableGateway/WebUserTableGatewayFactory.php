<?php
declare(strict_types=1);

namespace WebUser\Container\TableGateway;

use Psr\Container\ContainerInterface;
use WebUser\TableGateway\WebUserTableGateway;
use WebUser\TableGateway\WebUserTableGatewayInterface;

final class WebUserTableGatewayFactory
{
    /**
     * @param ContainerInterface $container
     * @return WebUserTableGatewayInterface
     */
    public function __invoke(ContainerInterface $container) : WebUserTableGatewayInterface
    {
        return new WebUserTableGateway();
    }
}
