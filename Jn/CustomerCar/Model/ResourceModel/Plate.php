<?php declare(strict_types=1);

namespace Jn\CustomerCar\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Plate extends AbstractDb
{
    /** @var string  */
    const MAIN_TABLE = 'jn_customercar_register';

    /** @var string  */
    const ID_FIELD_NAME = 'id';

    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}
