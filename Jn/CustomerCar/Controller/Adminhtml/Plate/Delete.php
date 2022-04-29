<?php declare(strict_types=1);

namespace Jn\CustomerCar\Controller\Adminhtml\Plate;

use Jn\CustomerCar\Model\Plate;
use Jn\CustomerCar\Model\PlateFactory;
use Jn\CustomerCar\Model\ResourceModel\Plate as PlateResource;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Delete extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Jn_CustomerCar::plate_delete';

    /** @var PlateFactory */
    protected $plateFactory;

    /** @var PlateResource */
    protected $plateResource;

    /**
     * Delete constructor.
     * @param Context $context
     * @param PlateFactory $plateFactory
     * @param PlateResource $plateResource
     */
    public function __construct(
        Context $context,
        PlateFactory $plateFactory,
        PlateResource $plateResource
    ) {
        $this->plateFactory = $plateFactory;
        $this->plateResource = $plateResource;
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        try {
            $id = $this->getRequest()->getParam('id');
            /** @var Plate $plate */
            $plate = $this->plateFactory->create();
            $this->plateResource->load($plate, $id);
            if ($plate->getId()) {
                $this->plateResource->delete($plate);
                $this->messageManager->addSuccessMessage(__('The record has been deleted.'));
            } else {
                $this->messageManager->addErrorMessage(__('The record does not exist.'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var Redirect $redirect */
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $redirect->setPath('*/*');
    }
}
