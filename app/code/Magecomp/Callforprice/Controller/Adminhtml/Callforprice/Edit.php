<?php
namespace Magecomp\Callforprice\Controller\Adminhtml\Callforprice;
use Magento\Framework\Controller\ResultFactory;
use Magecomp\Callforprice\Controller\Adminhtml\Callforprice;

class Edit extends Callforprice
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $id = $this->getRequest()->getParam('id');
        $model = $this->initModel();

        if ($this->getRequest()->getParam('type')) {
            $model->setType($this->getRequest()->getParam('type'));
        }

        if ($id && !$model->getId()) {
            $this->messageManager->addError(__('This item not exists.'));
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        $this->initPage($resultPage)->getConfig()->getTitle()->prepend($id ? $model->getName() : __('New Filter'));

        return $resultPage;
    }
}
