<?php

namespace Emmesaurus\Reviews\Controller\Manage;

use Magento\Framework\Controller\ResultFactory;

class Reviews extends \Magento\Framework\App\Action\Action
{
    /**
     * Contact action
     *
     * @return void
     */
    public function execute()
    {
        $post = $this->getRequest()->getPost();

        if ($post) {
            // Retrieve your form data
            $subject = $post['subject'];
            $message = $post['message'];

            // Doing-something with...

            // Display the succes form validation message
            $this->messageManager->addSuccess('Message sent !');

            // Redirect to your form page (or anywhere you want...)
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl('/emmesaurus/reviews/reviews);

            return $resultRedirect;
        }
        // Render the page 
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}