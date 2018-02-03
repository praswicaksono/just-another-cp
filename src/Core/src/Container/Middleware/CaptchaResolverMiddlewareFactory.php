<?php
declare(strict_types=1);

namespace Core\Container\Middleware;

use Core\Middleware\CaptchaResolverMiddleware;
use Psr\Container\ContainerInterface;

/**
 * Class CaptchaResolverMiddlewareFactory
 * @package Core\Container\Middleware
 */
final class CaptchaResolverMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     * @return CaptchaResolverMiddleware
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')['captcha'];
        return new CaptchaResolverMiddleware(new $config['class']($config['options']));
    }
}
