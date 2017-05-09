<?php
namespace Magecomp\Callforprice\Controller\Adminhtml\Callforprice;
use Magento\Framework\Controller\ResultFactory;
use Magecomp\Callforprice\Controller\Adminhtml\Callforprice;

class Delete extends Callforprice
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $model = $this->initModel();

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        if ($model->getId()) {
            try {
                $model->delete();

                $this->messageManager->addSuccess(__('The data has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
            }
        } else {
            $this->messageManager->addError(__('This data no longer exists.'));

            return $resultRedirect->setPath('*/*/');
        }
    }
}
