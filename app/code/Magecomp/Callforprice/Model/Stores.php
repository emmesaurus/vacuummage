<?php
namespace Magecomp\Callforprice\Model;
class Stores implements \Magento\Framework\Option\ArrayInterface
{
    protected $_systemStore;
	protected $_objectManager;
	
	public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager,\Magento\Store\Model\System\Store $systemStore)
	{
		$this->_systemStore = $systemStore;
		$this->_objectManager = $objectManager;
	}
	
    public function toOptionArray()
    {
        return $this->_systemStore->getStoreValuesForForm(false, true);
    }
}

?>