<?php
declare(strict_types=1);

namespace Core\Container\Middleware;

use Core\Middleware\DatabaseMiddleware;
use Psr\Container\ContainerInterface;

/**
 * Class DatabaseMiddlewareFactory
 * @package Core\Container\Middleware
 */
final class DatabaseMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     * @return DatabaseMiddleware
     */
    public function __invoke(ContainerInterface $container) : DatabaseMiddleware
    {
        return new DatabaseMiddleware($container);
    }
}
