<?php

namespace School\Creation\Block\Index;


use School\Creation\Model\CreateFactory;
use School\Creation\Model\StudentFactory;



class Studentsuccess extends \Magento\Framework\View\Element\Template {

    public function __construct(\Magento\Catalog\Block\Product\Context $context, array $data = [],\Magento\Framework\App\Request\Http $request,CreateFactory $modelCreateFactory,\Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,StudentFactory $modelStudentFactory){
		$this->request = $request;
       
        $this->_modelCreateFactory = $modelCreateFactory;
        $this->_modelStudentFactory = $modelStudentFactory;
        $this->_orderCollectionFactory = $orderCollectionFactory;

        parent::__construct($context, $data);

    }

    public function getBaseurl()
    {
        return  $this->_storeManager->getStore()->getBaseUrl();

    }

    public function getOrder()
    {

      $collection = $this->_orderCollectionFactory->create()->addAttributeToSelect('*')
                        ->addFieldToFilter('school_id', array('eq' => $this->getSchoolId()))
                        ->getData();

      return $collection;
        



    }

    public function getSchoolId(){
          
          $seller_model = $this->_modelStudentFactory->create();
          $collection = $seller_model->getCollection()->addFieldToFilter('student_id',$this->getIddata())->getData();
          return $collection[0]['school_id'];
    
    }

  

    public function getIddata()
    {
        return $this->request->getParam('id');
    }



    protected function _prepareLayout()
    {    	        
    	$this->pageConfig->getTitle()->set('Order Information');
        return parent::_prepareLayout();
    }




}