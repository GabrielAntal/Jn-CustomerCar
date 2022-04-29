<?php

namespace Jn\CustomerCar\Model\Api;

use Jn\CustomerCar\Model\ResourceModel\Plate\CollectionFactory;

use Psr\Log\LoggerInterface;

class GetRegister
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
     * GetRegister constructor.
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

    public function getRegisterById()
    {
        $response = ['success' => false];

        try {
            $message = "No register found";
            $id = $this->request->getParam('id');
            $plates = $this->plateCollection->create();
            $plate = $plates->getItemByColumnValue('id', $id);
            $plateRegisterData = [];
            if ($plate) {
                $plateRegisterData = $plate->getData();
                $message = "Success";
            }

            $response = ['success' => true, 'message' => $message, 'data' => $plateRegisterData];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
            $this->logger->info($e->getMessage());
        }
        $returnArray = json_encode($response);
        return $returnArray;
    }
}
