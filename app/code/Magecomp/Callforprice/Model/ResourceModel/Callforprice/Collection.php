<?php
namespace Magecomp\Callforprice\Model\ResourceModel\Callforprice;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magecomp\Callforprice\Model\Callforprice', 'Magecomp\Callforprice\Model\ResourceModel\Callforprice');
    }
}
