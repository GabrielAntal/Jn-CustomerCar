<?php

namespace Jn\CustomerCar\Model\Api;

use Jn\CustomerCar\Model\ResourceModel\Plate\CollectionFactory;

use Psr\Log\LoggerInterface;

class GetRegisterPlates
{
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var \Magento\Framework\Webapi\Rest\Request
     */
    protected $request;

    /**
     * @var CollectionFactory
     */
    protected $plateCollection;

    /**
     * GetRegisterPlates constructor.
     * @param LoggerInterface $logger
     * @param \Magento\Framework\Webapi\Rest\Request $request
     * @param CollectionFactory $plateCollection
     */
    public function __construct(
        LoggerInterface $logger,
        \Magento\Framework\Webapi\Rest\Request $request,
        CollectionFactory $plateCollection
    ) {
        $this->logger = $logger;
        $this->request = $request;
        $this->plateCollection = $plateCollection;
    }

    /**
     * @return false|string
     */
    public function getRegisterByPlate()
    {
        $response = ['success' => false];

        try {
            $number = $this->request->getParam('number');
            $plates = $this->plateCollection->create()
            ->addFieldToFilter('vehicle_plate', ['like' => '%' . $number])->getItems();

            $response = ['success' => true, 'message' => 'No registers found', 'data' => $plates];
            if ($plates) {
                $matchPlates = [];
                foreach ($plates as $plate) {
                    $matchPlates[$plate->getData('id')] = $plate->getData();
                }

                $response = ['success' => true, 'message' => 'Success', 'data' => $matchPlates];
            }
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
            $this->logger->info($e->getMessage());
        }
        $returnArray = json_encode($response);
        return $returnArray;
    }
}
