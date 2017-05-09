<?php
namespace Magecomp\Callforprice\Controller\Adminhtml\Callforprice;
use Magento\Framework\Controller\ResultFactory;
use Magecomp\Callforprice\Controller\Adminhtml\Callforprice;

class Index extends Callforprice
{
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $this->initPage($resultPage);
        return $resultPage;
    }
}
