<?php
declare(strict_types=1);


namespace WebUser\TableGateway;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

/**
 * Class WebUserTableGateway
 * @package WebUser\TableGateway
 */
final class WebUserTableGateway extends AbstractTableGateway implements WebUserTableGatewayInterface
{
    public function __construct()
    {
        $this->table = 'web_users';
        $this->featureSet = new FeatureSet();
        $this->featureSet->addFeature(new GlobalAdapterFeature());
        $this->initialize();
    }

    /**
     * @param string $email
     * @return array|\ArrayObject|null
     */
    public function findByEmail(string $email) : ?array
    {
        return (array) $this->select(['email' => $email])->current();
    }
}
