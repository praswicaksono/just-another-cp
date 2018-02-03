<?php
declare(strict_types=1);

namespace WebUser\TableGateway;

use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Interface WebUserTableGatewayInterface
 * @package WebUser\TableGateway
 */
interface WebUserTableGatewayInterface extends TableGatewayInterface
{
    /**
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email) : ?array;
}
