<?php
namespace Magecomp\Callforprice\Block\Adminhtml\Callforprice\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Tabs as WidgetTabs;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Registry;
/**
 * Admin blog category edit form tabs
 */
class Tabs extends WidgetTabs
{
     /**
     * @var Registry
     */
    protected $registry;

    /**
     * {@inheritdoc}
     * @param Registry         $registry
     * @param Context          $context
     * @param EncoderInterface $jsonEncoder
     * @param Session          $authSession
     */
    public function __construct(
        Registry $registry,
        Context $context,
        EncoderInterface $jsonEncoder,
        Session $authSession
    ) {
        $this->registry = $registry;

        parent::__construct($context, $jsonEncoder, $authSession);
    }
	/**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('callforpriceTabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Callforprice Configuration'));
    }
	
	protected function _beforeToHtml()
    {
        $this->addTab('general_section', [
                'label'   => __('General'),
                'title'   => __('General'),
                'content' => $this->getLayout()
                    ->createBlock('\Magecomp\Callforprice\Block\Adminhtml\Callforprice\Edit\Tab\General')->toHtml(),
            ]);
		return parent::_beforeToHtml();
    }
}
