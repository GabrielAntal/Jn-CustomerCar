<?php

namespace Jn\CustomerCar\Model\Api;

use Jn\CustomerCar\Model\ResourceModel\Plate\CollectionFactory;

use Psr\Log\LoggerInterface;

class UpdatePlateRegister
{
    protected $logger;

    protected $request;

    protected $plateCollection;

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

    public function updateRegister()
    {
        $response = ['success' => false];

        try {
            $body = $this->request->getBodyParams();
            $id = $this->request->getParam('id');
            $plates = $this->plateCollection->create();
            $plate = $plates->getItemByColumnValue('id', $id);

            if ($plate) {
                $plate->setData('customer_name', $body['customer_name']);
                $plate->setData('customer_phone', $body['customer_phone']);
                $plate->setData('customer_taxvat', $body['customer_taxvat']);
                $plate->setData('vehicle_plate', $body['vehicle_plate']);
                $plate->save();
            }

            $response = ['success' => true, 'message' => 'Success update'];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
            $this->logger->info($e->getMessage());
        }
        $returnArray = json_encode($response);
        return $returnArray;
    }
}
