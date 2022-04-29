<?php declare(strict_types=1);

namespace Jn\CustomerCar\Controller\Adminhtml\Plate;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Jn\CustomerCar\Model\Plate;
use Jn\CustomerCar\Model\PlateFactory;
use Jn\CustomerCar\Model\ResourceModel\Plate as PlateResource;

class InlineEdit extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Jn_CustomerCar::plate_save';

    /** @var JsonFactory */
    protected $jsonFactory;

    /** @var PlateFactory */
    protected $plateFactory;

    /** @var PlateResource */
    protected $plateResource;

    /**
     * InlineEdit constructor.
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param PlateFactory $plateFactory
     * @param PlateResource $plateResource
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        PlateFactory $plateFactory,
        PlateResource $plateResource
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->plateFactory = $plateFactory;
        $this->plateResource = $plateResource;
    }

    public function execute()
    {
        $json = $this->jsonFactory->create();
        $messages = [];
        $error = false;
        $isAjax = $this->getRequest()->getParam('isAjax', false);
        $items = $this->getRequest()->getParam('items', []);

        if (!$isAjax || !count($items)) {
            $messages[] = __('Please correct the data sent.');
            $error = true;
        }

        if (!$error) {
            foreach ($items as $item) {
                $id = $item['id'];
                try {
                    /** @var Plate $plate */
                    $plate = $this->plateFactory->create();
                    $this->plateResource->load($plate, $id);
                    $plate->setData(array_merge($plate->getData(), $item));
                    $this->plateResource->save($plate);
                } catch (\Exception $e) {
                    $messages[] = __("Something went wrong while saving item $id");
                    $error = true;
                }
            }
        }

        return $json->setData([
            'messages' => $messages,
            'error' => $error,
        ]);
    }
}
