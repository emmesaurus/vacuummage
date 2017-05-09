<?php
namespace Magecomp\Callforprice\Controller\Index;

use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\ScopeInterface;
use Magecomp\Callforprice\Model\CallforpriceFactory;
use Magento\Catalog\Model\ProductFactory;
class Post extends \Magento\Framework\App\Action\Action
{
	/**
     * Recipient email config path
     */
    const XML_PATH_EMAIL_RECIPIENT = 'callforprice/adminemail/recipient_email';

    /**
     * Sender email config path
     */
    const XML_PATH_EMAIL_SENDER = 'callforprice/adminemail/sender_email_identity';

    /**
     * Email template config path
     */
    const XML_PATH_EMAIL_TEMPLATE = 'callforprice/adminemail/email_template';

    /**
     * Enabled config path
     */
    const XML_PATH_AUTOREPLY_ENABLED = 'callforprice/autoreply/enable';
	/**
     * Enabled Auto reply sender
     */
    const XML_PATH_AUTOREPLY_SENDER = 'callforprice/autoreply/sender_email_identity';
	/**
     * Enabled Auto reply Template
     */
    const XML_PATH_AUTOREPLY_TEMPLATE = 'callforprice/autoreply/email_template';
	/*
	  * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
	 
    protected $_transportBuilder;

    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
	
	protected $callforpriceFactory;
	
	protected $productFactory;
	
	protected $_countryCollectionFactory;
	
	protected $_timezoneInterface;
	
	public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,		
		\Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory,
		\Magento\Framework\Stdlib\DateTime\DateTime $timezoneInterface,
		CallforpriceFactory $callforpriceFactory,
		ProductFactory $productFactory,
		array $data = []
    ) {
		$this->productFactory = $productFactory;
		$this->_countryCollectionFactory = $countryCollectionFactory;
		$this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
		$this->callforpriceFactory = $callforpriceFactory;		
		$this->_timezoneInterface = $timezoneInterface;
		parent::__construct($context);
    }
	
	public function execute()
	{
    	$postdata = $this->getRequest()->getPostValue();
		if($postdata)
		{
			$this->inlineTranslation->suspend();
        	try 
			{
				if(array_key_exists('g-recaptcha-response',$postdata))
				{
					$ccode = $postdata['g-recaptcha-response'];
					$secret = $this->scopeConfig->getValue('callforprice/googlerecaptcha/secretkey',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	    			$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$ccode);
        			$responseData = json_decode($verifyResponse);
					if(!$responseData->success)
					{
						echo 'wrong';
						return;
					}
				}
				$model = $this->callforpriceFactory->create();
				$countries = $this->getCountries();
				$country_name = '';
				foreach ( $countries as $countryKey => $country )
				{
					if($country['value'] == $postdata['country'])
						$country_name = $country['label'];
				}
				$product = $this->productFactory->create()->load($postdata['cproduct_id']);
				$model->setName($postdata['name']);
				$model->setEmail($postdata['email']);
				$model->setProductName($product->getName());
				$model->setTelephone($postdata['telephone']);
				$model->setCountry($country_name);
				$model->setComment($postdata['comment']);
				$model->setCreatedAt($this->_timezoneInterface->date('Y-m-d H:i:s'));
				$model->setUpdatedAt($this->_timezoneInterface->date('Y-m-d H:i:s'));
				$model->save();
				
				/* Code to send email to Admin */
				$postObject = new \Magento\Framework\DataObject();
				$data = ['name' => $postdata['name'], 'email' => $postdata['email'], 'product_name' => $product->getName(),'telephone' => $postdata['telephone'], 'country' => $country_name, 'comment' => $postdata['comment']];
				$postObject->setData($data);
				
				$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
				$transport = $this->_transportBuilder
					->setTemplateIdentifier($this->scopeConfig->getValue(self::XML_PATH_EMAIL_TEMPLATE, $storeScope))
					->setTemplateOptions(
						[
							'area' => \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
							'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
						]
					)
					->setTemplateVars(['data' => $postObject])
					->setFrom($this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, $storeScope))
					->addTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope))
					->getTransport();
	
				$transport->sendMessage();
				
				/* Code for the Auto reply */
				if($this->scopeConfig->getValue(self::XML_PATH_AUTOREPLY_ENABLED, $storeScope))
				{
					  $transports = $this->_transportBuilder
					  ->setTemplateIdentifier($this->scopeConfig->getValue(self::XML_PATH_AUTOREPLY_TEMPLATE, $storeScope))
					  ->setTemplateOptions(
						  [
							  'area' => \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
							  'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
						  ]
					  )
					  ->setTemplateVars(['data' => $postObject])
					  ->setFrom($this->scopeConfig->getValue(self::XML_PATH_AUTOREPLY_SENDER, $storeScope))
					  ->addTo($postdata['email'],$storeScope)
					  ->getTransport();
	
					$transports->sendMessage();
				}
				echo 'sucess';
			} catch (\Exception $e) {
            	echo 'error';
            }
			$this->inlineTranslation->resume();
		}
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
		$destinations = (string)$this->scopeConfig->getValue(
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
}