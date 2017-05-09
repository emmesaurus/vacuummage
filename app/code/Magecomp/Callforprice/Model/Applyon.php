<?php
namespace Magecomp\Callforprice\Model;
class Applyon implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('Products')],
            ['value' => 1, 'label' => __('Categories')],
			['value' => 2, 'label' => __('Global')]
        ];
    }
}

?>