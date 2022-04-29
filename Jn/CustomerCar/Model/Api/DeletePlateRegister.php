<?php

namespace Jn\CustomerCar\Model\Api;

use Jn\CustomerCar\Model\PlateFactory;

use Psr\Log\LoggerInterface;

class DeletePlateRegister
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
     * @var PlateFactory
     */
    protected $plateFactory;

    /**
     * DeletePlateRegister constructor.
     * @param LoggerInterface $logger
     * @param \Magento\Framework\Webapi\Rest\Request $request
     * @param PlateFactory $plateFactory
     */
    public function __construct(
        LoggerInterface $logger,
        \Magento\Framework\Webapi\Rest\Request $request,
        PlateFactory $plateFactory
    ) {
        $this->logger = $logger;
        $this->request = $request;
        $this->plateFactory = $plateFactory;
    }

    /**
     * @return false|string
     */
    public function deleteRegister()
    {
        $response = ['success' => false];

        try {
            $id = $this->request->getParam('id');
            $plate = $this->plateFactory->create()->load($id);

            if ($plate->getData()) {
                $plate->delete();
            }

            $response = ['success' => true, 'message' => 'Success delete'];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
            $this->logger->info($e->getMessage());
        }
        $returnArray = json_encode($response);
        return $returnArray;
    }
}
