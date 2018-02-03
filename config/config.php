<?php

use Zend\ConfigAggregator\ArrayProvider;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;
use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/../.env')) {
    (new Dotenv(__DIR__ . '/../'))->load();
}

if (! function_exists('env')) {
    function env(string $key) : ?string {
        $env = getenv($key);

        return ($env) ? $env : null;
    }
}

// To enable or disable caching, set the `ConfigAggregator::ENABLE_CACHE` boolean in
// `config/autoload/local.php`.
$cacheConfig = [
    'config_cache_path' => 'data/config-cache.php',
];

$aggregator = new ConfigAggregator([
    \Zend\I18n\ConfigProvider::class,
    \Core\ConfigProvider::class,
    \WebUser\ConfigProvider::class,
    \GameServer\ConfigProvider::class,
    \Theme\ConfigProvider::class,
    \Homepage\ConfigProvider::class,
    \Zend\Cache\ConfigProvider::class,
    \Zend\Db\ConfigProvider::class,
    \Zend\ProblemDetails\ConfigProvider::class,
    \Zend\Paginator\ConfigProvider::class,
    \Zend\Mail\ConfigProvider::class,
    \Zend\Expressive\Csrf\ConfigProvider::class,
    \Zend\Form\ConfigProvider::class,
    \Zend\InputFilter\ConfigProvider::class,
    \Zend\Filter\ConfigProvider::class,
    \Zend\Validator\ConfigProvider::class,
    \Zend\Hydrator\ConfigProvider::class,
    \Zend\Expressive\Session\Ext\ConfigProvider::class,
    \Zend\Expressive\Flash\ConfigProvider::class,
    \Zend\Expressive\Session\ConfigProvider::class,
    // Include cache configuration
    new ArrayProvider($cacheConfig),



    // Load application config in a pre-defined order in such a way that local settings
    // overwrite global settings. (Loaded as first to last):
    //   - `global.php`
    //   - `*.global.php`
    //   - `local.php`
    //   - `*.local.php`
    new PhpFileProvider(realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php'),

    // Load development config if it exists
    new PhpFileProvider(realpath(__DIR__) . '/development.config.php'),
], $cacheConfig['config_cache_path']);

return $aggregator->getMergedConfig();
