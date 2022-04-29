<?php declare(strict_types=1);

namespace Jn\CustomerCar\Model;

use Magento\Framework\Model\AbstractModel;

class Plate extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Plate::class);
    }
}
