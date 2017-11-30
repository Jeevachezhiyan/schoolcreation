<?php

namespace School\Creation\Block\Index;


class Success extends \Magento\Framework\View\Element\Template {

    public function __construct(\Magento\Catalog\Block\Product\Context $context, array $data = [],\Magento\Framework\App\Request\Http $request) {
		$this->request = $request;
        parent::__construct($context, $data);

    }

    public function getIddata()
    {
        return $this->request->getParam('id');
    }

    public function getBaseurl()
    {
        return  $this->_storeManager->getStore()->getBaseUrl();

    }


    protected function _prepareLayout()
    {    	        
    	$this->pageConfig->getTitle()->set(__('Create New Seller and Student Account'));
        return parent::_prepareLayout();
    }


}