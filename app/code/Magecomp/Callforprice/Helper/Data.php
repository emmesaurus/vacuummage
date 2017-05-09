<?php
namespace Magecomp\Callforprice\Helper;
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	const XML_PATH_ENABLED = 'callforprice/main/enable';
	const XML_PATH_APPLYON = 'callforprice/general/applyon';
	const XML_PATH_CUSTOMERGROUPS = 'callforprice/general/customer_groups';
	const XML_PATH_STOREVIEWS = 'callforprice/general/storeviews';
	const XML_PATH_REPLY_ENABLE	= 'callforprice/autoreply/enable';
	const XML_PATH_BUTTONTEXT	= 'callforprice/general/buttontext';
	const XML_PATH_CALLUSON	= 'callforprice/general/calluson';
	const XML_PATH_FORMTITLE	= 'callforprice/general/formtitle';
	const XML_PATH_CUSTOMMESSAGE	= 'callforprice/general/enablecustommsg';
	const XML_PATH_CUSTOMMESSAGETEXT	= 'callforprice/general/custommessage';
	const XML_PATH_SUCESSMESSAGE	= 'callforprice/general/successmsg';
	const XML_PATH_ERRORMESSAGE	= 'callforprice/general/errormsg';
	const XML_PATH_RECAPTCHA	= 'callforprice/googlerecaptcha/enable';
	
	protected $_objectManager;
	protected $_categoryFactory;
	protected $_storeManager;
	
	public function __construct(\Magento\Framework\App\Helper\Context $context,\Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Framework\Registry $registry,\Magento\Catalog\Model\CategoryFactory $categoryFactory,\Magento\Store\Model\StoreManagerInterface $storeManager)
	{
		$this->_objectManager = $objectManager;
		$this->registry = $registry;
		$this->_categoryFactory = $categoryFactory;
		$this->_storeManager = $storeManager;
		parent::__construct($context);
	}
	
	public function isEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
	
	public function getButtontext()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_BUTTONTEXT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
	
	public function getCallus()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CALLUSON,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
	
	public function getCustomMessage()
	{
		if($this->scopeConfig->getValue(self::XML_PATH_CUSTOMMESSAGE,\Magento\Store\Model\ScopeInterface::SCOPE_STORE))
		{
			return $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMMESSAGETEXT,\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		}
		return false;
	}
	
	public function getFormtitle()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_FORMTITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
	
	public function isApplyon()
	{
		return $this->scopeConfig->getValue(
            self::XML_PATH_APPLYON,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
	}
	
	public function isAutoreplyon()
	{
		return $this->scopeConfig->getValue(
            self::XML_PATH_REPLY_ENABLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
	}
	
	public function isValidCustomerGroup()
	{
		$customerGroups = explode(",", $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMERGROUPS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
		
		$customerSession = $this->_objectManager->create('Magento\Customer\Model\Session');
		$customerGroupId = $customerSession->getCustomerGroupId();
		
		if (in_array($customerGroupId, $customerGroups)) {
			return true;
		}

        return false;
	}
	
	public function isValidStoreViews()
	{
		if($this->scopeConfig->getValue(self::XML_PATH_STOREVIEWS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE)==0){ return true;}		
		
		$storeviews = explode(",", $this->scopeConfig->getValue(
            self::XML_PATH_STOREVIEWS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
		
		if (in_array($this->_storeManager->getStore()->getId(), $storeviews)) {
			return true;
		}

        return false;
	}
	
	public function getSucessMessage()
	{
		return $this->scopeConfig->getValue(
            self::XML_PATH_SUCESSMESSAGE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
	}
	
	public function getErrorMessage()
	{
		return $this->scopeConfig->getValue(
            self::XML_PATH_ERRORMESSAGE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
	}
	
	public function isGoogleRecaptcha()
	{
		return $this->scopeConfig->getValue(
            self::XML_PATH_RECAPTCHA,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
	}
	
	public function getCallforprice($product_id)
	{
		unset($options);
		$options = [];
		if($this->isEnabled())
		{
			if($this->isValidStoreViews())
			{
				if($this->isValidCustomerGroup())
				{
					if($this->getCustomMessage())
					{
						$options['custom_message'] = $this->getCustomMessage();
					}
					$product = $this->_objectManager->create('Magento\Catalog\Model\Product')->load($product_id,\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
					if($this->isApplyon() == 2)
					{
						$options['button_text'] = $this->getButtontext();
						return $options;
					}
					
					if($this->isApplyon() == 0)
					{
						if($product->getCallforprice())
						{
							if($product->getButtontext() != '')
								$options['button_text'] = $product->getButtontext();
							else
								$options['button_text'] = $this->getButtontext();
							return $options;	
						}
					}
					
					if($this->isApplyon() == 1)
					{
						$catids = $product->getCategoryIds();
						foreach($catids as $catid)
						{
							$category = $this->_categoryFactory->create()->load($catid);
							if($category->getCallforprice() > 0)
							{
								if($category->getButtontext())
									$options['button_text'] = $category->getButtontext();
								else
									$options['button_text'] = $this->getButtontext();
							}
						}
						return $options;
					}
				}
			}
		}
		return $options;
	}
}