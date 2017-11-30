<?php

namespace School\Creation\Block\Index;


class Create extends \Magento\Framework\View\Element\Template {

    public function __construct(\Magento\Catalog\Block\Product\Context $context, array $data = []) {

        parent::__construct($context, $data);

    }


    protected function _prepareLayout()
    {    	        
    	$this->pageConfig->getTitle()->set(__('Seller Registration'));
        return parent::_prepareLayout();
    }

     public function getBaseurl()
    {
        return  $this->_storeManager->getStore()->getBaseUrl();

    }



}
