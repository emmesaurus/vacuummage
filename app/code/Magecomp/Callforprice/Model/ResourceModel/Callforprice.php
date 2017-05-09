<?php
namespace Magecomp\Callforprice\Model\ResourceModel;

class Callforprice extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	protected function _construct()
    {
        $this->_init('callforprice', 'callforprice_id');
    }
}
