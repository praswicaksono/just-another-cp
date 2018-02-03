<?php

namespace Homepage;
use Homepage\Action\HomePageAction;
use Homepage\Container\Action\HomePageFactory;
use Theme\Helper\Path;

/**
 * The configuration provider for the Homepage module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    private const NAMESPACE = 'homepage';

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
            'dependencies'  => $this->getDependencies(),
            'templates'     => $this->getTemplates(),
            'routes'        => $this->getRoutes(),
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
            ],
            'factories'  => [
                HomePageAction::class => HomePageFactory::class,
            ],
        ];
    }

    public function getRoutes() : array
    {
        return [
            [
                'path'          => '/',
                'middleware'    => [
                    HomePageAction::class,
                ],
                'methods'       => ['GET'],
                'name'          => 'home'
            ]

        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                self::NAMESPACE    => [Path::getThemeDir() . '/' . self::NAMESPACE],
            ],
        ];
    }
}
