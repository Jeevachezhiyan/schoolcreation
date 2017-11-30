<?php
namespace School\Creation\Block\Index;

use School\Creation\Model\CreateFactory;
use School\Creation\Model\StudentFactory;
use School\Creation\Model\SellerFactory;

class Coordinatorsuccess extends \Magento\Framework\View\Element\Template {

    public function __construct(\Magento\Catalog\Block\Product\Context $context, array $data = [],\Magento\Framework\App\Request\Http $request,CreateFactory $modelCreateFactory,\Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,StudentFactory $modelStudentFactory,SellerFactory $modelSellerFactory){
        $this->request = $request;
       
        $this->_modelCreateFactory = $modelCreateFactory;
        $this->_modelStudentFactory = $modelStudentFactory;
        $this->_modelSellerFactory = $modelSellerFactory;
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
                        ->addFieldToFilter('school_name', array('eq' => $this->getSchoolName()))
                        ->getData();

      return $collection;
    }

    public function getSchoolId(){
          
          $seller_model = $this->_modelStudentFactory->create();
          $collection = $seller_model->getCollection()->addFieldToFilter('school_id',$this->getIddata())->getData();
          return $collection[0]['school_name'];
   } 

    public function getSchoolName(){

          $seller_model = $this->_modelCreateFactory->create();
          $collection = $seller_model->getCollection()->addFieldToFilter('school_id',$this->getIddata())->getData();
          return $collection[0]['school_name'];

    }

    

    public function getSellerId(){
          
          $seller_model = $this->_modelSellerFactory->create();
          $collection = $seller_model->getCollection()->addFieldToFilter('school_id',$this->getIddata())->getData();
          return $collection;
    
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
