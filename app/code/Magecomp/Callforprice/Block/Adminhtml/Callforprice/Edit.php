<?php
namespace Magecomp\Callforprice\Block\Adminhtml\Callforprice;

/**
 * Admin blog category
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize cms page edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Magecomp_Callforprice';
        $this->_controller = 'adminhtml_callforprice';
		parent::_construct();
		$this->buttonList->remove('delete');
		$this->buttonList->remove('saveandcontinue');
		$this->buttonList->remove('save');
       // if ($this->_isAllowedAction('Magecomp_Callforprice::callforprice')) {
//            $this->buttonList->add(
//                'saveandcontinue',
//                [
//                    'label' => __('Save and Continue Edit'),
//                    'class' => 'save',
//                    'data_attribute' => [
//                        'mage-init' => [
//                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
//                        ],
//                    ]
//                ],
//                -100
//            );
//        } else {
//            $this->buttonList->remove('save');
//        }

        //if (!$this->_isAllowedAction('Magecomp_callforprice::callforprice')) {
//            $this->buttonList->remove('delete');
//			$this->buttonList->remove('saveandcontinue');
//        }
    }


    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    //protected function _getSaveAndContinueUrl()
//    {
//        return $this->getUrl('*/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '{{tab_id}}']);
//    }

    /**
     * Prepare layout
     *
     * @return \Magento\Framework\View\Element\AbstractBlock
     */
    protected function _prepareLayout()
    {
        //$this->_formScripts[] = "
//            function toggleEditor() {
//                if (tinyMCE.getInstanceById('category_content') == null) {
//                    tinyMCE.execCommand('mceAddControl', false, 'category_content');
//                } else {
//                    tinyMCE.execCommand('mceRemoveControl', false, 'category_content');
//                }
//            };
//        ";
        return parent::_prepareLayout();
    }
}
