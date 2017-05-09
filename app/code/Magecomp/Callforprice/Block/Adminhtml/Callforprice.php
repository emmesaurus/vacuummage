<?php
namespace Magecomp\Callforprice\Block\Adminhtml;
class Callforprice extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
		$this->_controller = 'adminhtml_callforprice';
        $this->_blockGroup = 'Magecomp_Callforprice';
        $this->_headerText = __('Manage Call For Price Quotes');
        //$this->_addButtonLabel = __('Add New Entry'); 
        parent::_construct();
		$this->buttonList->remove('add');
	}
}