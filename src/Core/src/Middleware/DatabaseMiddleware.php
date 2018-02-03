<?php
declare(strict_types=1);

namespace Core\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

/**
 * Class DatabaseMiddleware
 * @package Core\Middleware
 */
final class DatabaseMiddleware implements MiddlewareInterface
{

    public const DB_ADAPTER = 'db_adapter';

    public const SQL_ABSTRACTION = 'sql_abstraction';


    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * DatabaseMiddleware constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $config = $this->container->get('config');

        $adapter = new Adapter($config['database']);
        $sql = new Sql($adapter);

        GlobalAdapterFeature::setStaticAdapter($adapter);

        return $delegate->process(
            $request
                ->withAttribute(self::DB_ADAPTER, $adapter)
                ->withAttribute(self::SQL_ABSTRACTION, $sql)
        );
    }
}
