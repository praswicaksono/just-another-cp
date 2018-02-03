<?php
declare(strict_types=1);


namespace Theme\Helper;

/**
 * Class Path
 * @package Theme\Helper
 */
final class Path
{
    public const THEME_DIR = __DIR__ . '/../../../../resources/theme';

    /**
     * @return string
     */
    public static function getThemeDir() : string
    {
        $theme = (! is_null(env('theme'))) ? env('theme') : 'default';

        if (! is_dir(self::THEME_DIR . '/' . $theme)) {
            $theme = 'default';
        }

        return self::THEME_DIR . '/' . $theme;
    }
    /**
     * @param string $namespace
     * @return bool
     */
    public static function isNamespaceExist(string $namespace) : bool
    {
        return is_dir(self::getThemeDir(). '/' . $namespace);
    }

    /**
     * @param string $namespace
     * @return string
     */
    public static function getNamespaceDir(string $namespace) : string
    {
        return self::getThemeDir() . '/' . $namespace;
    }

    /**
     * @return string
     */
    public static function getErrorDir() : string
    {
        return self::getThemeDir() . '/error';
    }

    /**
     * @return string
     */
    public static function getLayoutDir() : string
    {
        return self::getThemeDir() . '/layout';
    }

    /**
     * @return string
     */
    public static function getThemeAssetPath() : string
    {
        $theme = (! is_null(env('theme'))) ? env('theme') : 'default';

        return 'assets/' . $theme;
    }
}
