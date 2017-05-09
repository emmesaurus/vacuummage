<?php
namespace Magecomp\Callforprice\Block\Adminhtml\Callforprice\Edit\Tab;
use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store as SystemStore;

class General extends Form
{
    /**
     * @var SystemStore
     */
    protected $systemStore;


    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Context
     */
    protected $context;

    /**
     * {@inheritdoc}
     * @param SourceType  $sourceType
     * @param SystemStore $systemStore
     * @param FormFactory $formFactory
     * @param Registry    $registry
     * @param Context     $context
     */
    public function __construct(
        SystemStore $systemStore,
        FormFactory $formFactory,
        Registry $registry,
        Context $context
    ) {
        $this->systemStore = $systemStore;
        $this->formFactory = $formFactory;
        $this->registry = $registry;
        $this->context = $context;

        parent::__construct($context);
    }
	
	protected function _prepareForm()
    {
        /* @var $model \Magento\Cms\Model\Page */
        $model = $this->registry->registry('current_model');
        $form = $this->formFactory->create();
        $form->setFieldNameSuffix('callforprice');
        $this->setForm($form);

		$general = $form->addFieldset('general', ['legend' => __('General Information')]);

        if ($model->getId()) {
            $general->addField('callforprice_id', 'hidden', [
                'name'  => 'callforprice_id',
                'value' => $model->getId(),
            ]);
        }

        $general->addField('name', 'text', [
            'label'    => __('Name'),
            'required' => true,
            'name'     => 'name',
            'value'    => $model->getData('name')
        ]);
		
		$general->addField('email', 'text', [
            'label'    => __('Customer Email'),
            'required' => true,
            'name'     => 'email',
            'value'    => $model->getData('email')
        ]);
		
		$general->addField('product_name', 'text', [
            'label'    => __('Product Name'),
            'required' => true,
            'name'     => 'product_name',
            'value'    => $model->getData('product_name')
        ]);
		
		$general->addField('country', 'text', [
            'label'    => __('Country'),
            'required' => true,
            'name'     => 'country',
            'value'    => $model->getData('country')
        ]);
		
		$general->addField('telephone', 'text', [
            'label'    => __('Country'),
            'required' => true,
            'name'     => 'telephone',
            'value'    => $model->getData('telephone')
        ]);
		
		$general->addField('comment', 'textarea', [
            'label'    => __('Comment'),
            'required' => true,
            'name'     => 'comment',
            'value'    => $model->getData('comment')
        ]);
		
        return parent::_prepareForm();
    }
}