<?php

namespace Jn\CustomerCar\Model\Api;

use Psr\Log\LoggerInterface;

use Jn\CustomerCar\Model\PlateFactory;

class CreatePlateRegister
{
    protected $logger;

    protected $request;

    protected $plateFactory;

    public function __construct(
        LoggerInterface $logger,
        \Magento\Framework\Webapi\Rest\Request $request,
        PlateFactory $plateFactory
    )
    {
        $this->logger = $logger;
        $this->request = $request;
        $this->plateFactory = $plateFactory;
    }

    /**
     * @return false|string
     */

    public function createRegister()
    {
        $response = ['success' => false];

        try {
            $body = $this->request->getBodyParams();

            $plateModel = $this->plateFactory->create();

            $plateModel->setData('customer_name', $body['customer_name']);
            $plateModel->setData('customer_phone', $body['customer_phone']);
            $plateModel->setData('customer_taxvat', $body['customer_taxvat']);
            $plateModel->setData('vehicle_plate', $body['vehicle_plate']);
            $plateModel->save();

            $response = ['success' => true, 'message' => 'Success'];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
            $this->logger->info($e->getMessage());
        }
        $returnArray = json_encode($response);
        return $returnArray;
    }
}
