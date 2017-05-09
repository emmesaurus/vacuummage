<?php
namespace Magecomp\Callforprice\Block\Adminhtml\Callforprice;

use Magento\Backend\Block\Widget\Context as Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data as BackendHelper;
use Magecomp\Callforprice\Model\ResourceModel\Callforprice\CollectionFactory as CallCollectionFactory;

class Grid extends Extended
{
     /**
     * @var RuleCollectionFactory
     */
	protected $callcollectionFactory;

    /**
     * {@inheritdoc}
     * @param RuleCollectionFactory $ruleCollectionFactory
     * @param Context               $context
     * @param BackendHelper         $backendHelper
     */
    public function __construct(
        CallCollectionFactory $callcollectionFactory,
        Context $context,
		BackendHelper $backendHelper		
    ) {
        $this->callcollectionFactory = $callcollectionFactory;

        parent::__construct($context, $backendHelper);
    }
	
	/**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
		
        $this->setId('callforprice_grid');
        $this->setDefaultSort('callforprice_id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
       
    }

    protected function _prepareCollection()
    {
        $collection = $this->callcollectionFactory->create();
		$this->setCollection($collection);
		return parent::_prepareCollection();
    }
	/**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'callforprice_id',
            [
                'header' => __('ID'),
                'index' => 'callforprice_id',
                'class' => 'callforprice_id'
            ]
        );
		
		$this->addColumn(
			'name',
			[
        		'header'    => __('Customer Name'),
        		'index'     => 'name',
				'class' => 'name'
    		]
		);
		
		$this->addColumn(
			'email',
			[
        		'header'    => __('Customer Email'),
        		'index'     => 'email',
				'class' => 'email'
    		]
		);
		
		$this->addColumn(
			'product_name',
			[
        		'header'    => __('Product Name'),
        		'index'     => 'product_name',
				'class' => 'product_name'
    		]
		);
		
		$this->addColumn(
			'telephone',
			[
        		'header'    => __('Telephone'),
        		'index'     => 'telephone',
				'class' => 'telephone'
    		]
		); 
	
		$this->addColumn(
            'comment',
            [
                'header' => __('Comment'),
                'index' => 'comment',
                'class' => 'comment'
            ]
        );
		
		return parent::_prepareColumns();
    }

 /*
//     * @return $this
/*/     
     protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');

        $this->getMassactionBlock()->addItem('delete', [
            'label'   => __('Delete'),
            'url'     => $this->getUrl('*/*/massDelete'),
            'confirm' => __('Are you sure?'),
        ]);

        $this->getMassactionBlock()->addItem('export', [
            'label' => __('Export'),
            'url'   => $this->getUrl('*/*/massExport'),
        ]);

        return $this;
    }

    /*
     * @return string
     **/
    //public function getGridUrl()
//    {
//        return $this->getUrl('rules/*/grid', ['_current' => true]);
//    }

/*
     * @param \Magento\Catalog\Model\Product|\Magento\Framework\Object $row
     * @return string
*/     
    public function getRowUrl($row)
    {
        return $this->getUrl(
            'callforprice/*/edit',
            ['store' => $this->getRequest()->getParam('store'), 'id' => $row->getId()]
        );
    }
}
