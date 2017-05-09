<?php
namespace Magecomp\Callforprice\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Registry;
use Magecomp\Callforprice\Model\CallforpriceFactory;

abstract class Callforprice extends Action
{
    /**
     * @var RuleFactory
     */
    protected $callforpriceFactory;

    /**
     * @var Registry
     */
    protected $registry;


    /**
     * @var Context
     */
    protected $context;
	protected $_fileFactory;

    /**
     * {@inheritdoc}
     * @param RuleFactory    $ruleFactory
     * @param Registry       $registry
     * @param Context        $context
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        CallforpriceFactory $callforpriceFactory,
        Registry $registry,
        Context $context,
        ForwardFactory $resultForwardFactory,
		\Magento\Framework\App\Response\Http\FileFactory $fileFactory		
    ) {
        $this->callforpriceFactory = $callforpriceFactory;
        $this->registry = $registry;
        $this->context = $context;
		$this->_fileFactory = $fileFactory;		
        $this->resultForwardFactory = $resultForwardFactory;

        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     * @param \Magento\Backend\Model\View\Result\Page\Interceptor $resultPage
     * @return \Magento\Backend\Model\View\Result\Page\Interceptor
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Magecomp_Callforprice::callforprice');
        $resultPage->getConfig()->getTitle()->prepend(__('Call For Price Inquiries'));
        return $resultPage;
    }
	
	protected function initModel()
    {
        $model = $this->callforpriceFactory->create();

        if ($this->getRequest()->getParam('id')) {
            $model->load($this->getRequest()->getParam('id'));
        }

        $this->registry->register('current_model', $model);

        return $model;
    }

    /**
     * Current template model
     *
     * @return \Mirasvit\Feed\Model\Rule
     */
    
	/**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->context->getAuthorization()->isAllowed('Magecomp_Callforprice::callforprice');
    }
}
