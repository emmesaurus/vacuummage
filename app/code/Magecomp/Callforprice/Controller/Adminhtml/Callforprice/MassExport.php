<?php
namespace Magecomp\Callforprice\Controller\Adminhtml\Callforprice;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magecomp\Callforprice\Controller\Adminhtml\Callforprice;

class MassExport extends Callforprice
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
		$fileName = 'callforprice.csv';
        $content = '';
        $_columns = array(
            'Name', 'Email', 'Product Name', 'Country', 'Telephone', 'Comment', 'Created At'
        );
        $data = array();
        foreach ($_columns as $column) {
            $data[] = '"'.$column.'"';
        }
		$content .= implode(',', $data)."\n";
		
		foreach ($this->getRequest()->getParam('id') as $templateId)
		{
			
            $model = $this->callforpriceFactory->create()->load($templateId);
            $data = array();
            $data[] = trim($model->getName());
            $data[] = trim($model->getEmail());
            $data[] = trim($model->getProductName());
            $data[] = trim($model->getCountry());
            $data[] = trim($model->getTelephone());
			$data[] = trim($model->getComment());
			$data[] = trim($model->getCreatedAt());
			$content .= implode(',', $data)."\n";
            
        }
		$this->messageManager->addSuccess(__('Data has been exported successfully.'));
		return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
	}
}
