<?php
namespace Magecomp\Callforprice\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
	
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }
	
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        //$setup->startSetup();
  		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		$eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'callforprice',
            [
                'group' => 'Call for Price',
        		'label' => 'Call for Price',
				'type'  => 'int',
        		'input' => 'boolean',
        		'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'source' => '',
                'required' => false,
                'sort_order' => 1,
                'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_STORE,
                'used_in_product_listing' => true,
                'visible_on_front' => false
            ]
        );
		
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'buttontext',
            [
                'type' => 'varchar',
                'label' => 'Button Text',
				'backend' => '',
                'input' => 'text',
				'source' => '',
                'required' => false,
                'sort_order' => 2,
                'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_STORE,
                'group' => 'Call for Price',
                'used_in_product_listing' => true,
                'visible_on_front' => false
            ]
        );
		
		  //Category Attribute Create Script
		  $eavSetup->addAttribute(
			  \Magento\Catalog\Model\Category::ENTITY,
			  'callforprice',
			   [
				  'group' => 'Call for Price',
				  'label' => 'Call for Price',
				  'type'  => 'int',
				  'input' => 'select',
				  'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
				  'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
				  'required' => false,
				  'sort_order' => 1
			  ]
		  );
		  
		  $eavSetup->addAttribute(
			  \Magento\Catalog\Model\Category::ENTITY,
			  'buttontext',
			   [
				  'group' => 'Call for Price',
				  'label' => 'Button Text',
				  'type'  => 'varchar',
				  'input' => 'text',
				  'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
				  'required' => false,
				  'sort_order' => 3
			  ]
		  );
		$setup->endSetup();
    }
}