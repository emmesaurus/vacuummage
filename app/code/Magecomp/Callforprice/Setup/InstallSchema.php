<?php
namespace Magecomp\Callforprice\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
		$installer = $setup;
		$installer->startSetup();

		$table = $installer->getConnection()->newTable($installer->getTable('callforprice'))
		->addColumn(
			'callforprice_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			8,
			['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
			'Call For Price Id Primary key'
		)
		->addColumn(
            'name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Name'
		)
		->addColumn(
            'email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Customer Email'
		)
		->addColumn(
			'product_name',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => false],
			'Product Name'
		)
		->addColumn(
			'country',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => false],
			'Country'
		)
		->addColumn(
			'telephone',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => false],
			'Telephone'
		)
		->addColumn(
			'comment',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			'64k',
			['nullable' => false],
			'Comment'
		)
		->addColumn(
			'created_at',
			\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
			'Creation Time'
		)
		->addColumn(
			'updated_at',
			\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
			'Update Time'
        );
		$installer->getConnection()->createTable($table);
	}
}
