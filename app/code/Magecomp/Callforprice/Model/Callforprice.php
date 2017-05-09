<?php
namespace Magecomp\Callforprice\Model;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magecomp\Callforprice\Model\ResourceModel\Callforprice\CollectionFactory as CallCollectionFactory;

class Callforprice extends \Magento\Framework\Model\AbstractModel
{
	protected $collectionFactory;

    public function __construct(
        CallCollectionFactory $callCollectionFactory,
        Context $context,
        Registry $registry
    ) {
        $this->collectionFactory = $callCollectionFactory;
		parent::__construct($context, $registry);
    }
	
	public function _construct()
    {
		$this->_init('Magecomp\Callforprice\Model\ResourceModel\Callforprice');
	}
}