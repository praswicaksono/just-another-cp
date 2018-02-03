<?php

namespace Theme;

use Theme\Helper\Path;
use Theme\Twig\ThemeExtension;

/**
 * The configuration provider for the Theme module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
final class ConfigProvider
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
            'templates'    => $this->getTemplates(),
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
                ThemeExtension::class => ThemeExtension::class
            ],
            'factories'  => [
            ],
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
                'layout' => [Path::getLayoutDir()],
                'error'  => [Path::getErrorDir()],
            ],
        ];
    }
}
