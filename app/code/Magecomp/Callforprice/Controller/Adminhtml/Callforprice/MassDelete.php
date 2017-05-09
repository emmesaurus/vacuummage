<?php
namespace Magecomp\Callforprice\Controller\Adminhtml\Callforprice;
use Magecomp\Callforprice\Controller\Adminhtml\Callforprice;

class MassDelete extends Callforprice
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $deleted = 0;
        foreach ($this->getRequest()->getParam('id') as $id) {
            $this->callforpriceFactory->create()->load($id)->delete();
            $deleted++;
        }

        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been deleted.', $deleted)
        );

        return $resultRedirect->setPath('*/*/');
    }
}
