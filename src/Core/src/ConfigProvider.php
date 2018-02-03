<?php

namespace Core;

use Core\Container\Form\CaptchaResolverFactory;
use Core\Container\Middleware\CaptchaResolverMiddlewareFactory;
use Core\Container\Middleware\DatabaseMiddlewareFactory;
use Core\Lib\Form\CaptchaResolver;
use Core\Middleware\CaptchaResolverMiddleware;
use Core\Middleware\DatabaseMiddleware;
use Core\Middleware\ValidateCsrfTokenMiddleware;

/**
 * The configuration provider for the Core module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
                ValidateCsrfTokenMiddleware::class  => ValidateCsrfTokenMiddleware::class,
            ],
            'factories'  => [
                DatabaseMiddleware::class           => DatabaseMiddlewareFactory::class,
                CaptchaResolverMiddleware::class    => CaptchaResolverMiddlewareFactory::class,
            ],
        ];
    }
}
