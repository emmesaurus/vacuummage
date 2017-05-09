<?php
namespace Magecomp\Callforprice\Block;
class Callforprice  extends \Magento\Framework\View\Element\Template
{
	protected $_countryCollectionFactory;
	protected $_recaptchalib;
    
	public function __construct(
		\Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
		\Magecomp\Callforprice\Model\Recaptchalib $recaptchalib,
        array $data = []
        ) {
            parent::__construct($context, $data);
			$this->_recaptchalib = $recaptchalib;
			$this->_recaptchalib->ReCaptchalib($this->getSecreateKey());
            $this->_countryCollectionFactory = $countryCollectionFactory;
    }
	
	public function _prepareLayout()
	{
		return parent::_prepareLayout();
	}
	
	public function getCountryCollection()
	{
		$collection = $this->_countryCollectionFactory->create()->loadByStore();
		return $collection;
	}
	/**
	 * Retrieve list of top destinations countries
	 *
	 * @return array
	 */
	protected function getTopDestinations()
	{
		$destinations = (string)$this->_scopeConfig->getValue(
			'general/country/destinations',
			\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
		return !empty($destinations) ? explode(',', $destinations) : [];
	}
 
 	/**
	 * Retrieve list of countries in array option
	 *
	 * @return array
	 */
	public function getCountries()
	{
		return $options = $this->getCountryCollection()
				->setForegroundCountries($this->getTopDestinations())
					->toOptionArray();
	}
	
	public function getSecreateKey()
	{
		return $this->_scopeConfig->getValue('callforprice/googlerecaptcha/secretkey',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}
	
	public function getSiteKey()
	{
		return $this->_scopeConfig->getValue('callforprice/googlerecaptcha/sitekey',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}
}
?>