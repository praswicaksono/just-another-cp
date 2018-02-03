<?php
declare(strict_types=1);

namespace Theme\Twig;

use Theme\Helper\Path;

/**
 * Class ThemeExtension
 * @package Theme\Twig
 */
final class ThemeExtension extends \Twig_Extension
{
    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('theme', [$this, 'renderThemeAssetUrl'])
        ];
    }

    /**
     * @param string $path
     * @param int|null $version
     * @return string
     */
    public function renderThemeAssetUrl(string $path, int $version = null) : string
    {
        $assetsVersion = $version !== null && $version !== '' ? '?v=' . $version : '';

        return Path::getThemeAssetPath() . '/' . $path . $assetsVersion;
    }
}
