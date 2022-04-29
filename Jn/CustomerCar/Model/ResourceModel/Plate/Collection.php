<?php declare(strict_types=1);

namespace Jn\CustomerCar\Model\ResourceModel\Plate;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Jn\CustomerCar\Model\Plate;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Plate::class, \Jn\CustomerCar\Model\ResourceModel\Plate::class);
    }
}
