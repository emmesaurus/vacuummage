<?php

namespace Emmesaurus\Reviews\Block;

class Reviews extends \Magento\Framework\View\Element\Template
{
    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
       }

    /**
     * Retrieve form action
     *
     * @return string
     */
    public function getFormAction()
    {
        return '/emmesaurus/reviews/reviews';
    }
}