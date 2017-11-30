<?php
namespace School\Creation\Block\Index;

use School\Creation\Model\SellerFactory;
use School\Creation\Model\CreateFactory;

class Sellersuccess extends \Magento\Framework\View\Element\Template {

    protected $categoryHelper;

    protected $categoryRepository;


    public function __construct(\Magento\Catalog\Block\Product\Context $context, array $data = [],\Magento\Framework\App\Request\Http $request,SellerFactory $modelSellerFactory,CreateFactory $modelCreateFactory,\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,\Magento\Catalog\Helper\Category $categoryHelper,    \Magento\Catalog\Model\CategoryRepository $categoryRepository)
    {
        $this->request = $request;

        $this->categoryHelper = $categoryHelper;
        $this->categoryRepository = $categoryRepository;

        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_modelSellerFactory = $modelSellerFactory;
        $this->_modelCreateFactory = $modelCreateFactory;
        parent::__construct($context, $data);

    }



    public function getCategoryCollection($isActive = true, $level = false, $sortBy = false, $pageSize = false)
    {
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');
                    //->addAttributeToFilter('school_name',array('in' => $this->getSchoolId()));        
        // select only active categories
        if ($isActive) {
            $collection->addIsActiveFilter();
        }
                
        // select categories of certain level
        // if ($level) {
        //     $collection->addLevelFilter($level);
        // }
        
        // // sort categories by some value
        // if ($sortBy) {
        //     $collection->addOrderField($sortBy);
        // }
        
        // // select certain number of categories
        // if ($pageSize) {
        //     $collection->setPageSize($pageSize); 
        // }    
        foreach ($collection as $key=>$category) {
          $collections[$key] =  $category->getSchoolName();

           if(in_array($this->getSchoolId(), explode(',',$collections[$key])))
           {
                $collecti[] =  $category->getId();

           }
          //$collections[] =  $category->getId();
        }
        // $categoryObj = $this->categoryRepository->get($collections);
        // $cat_url = $this->categoryHelper->getCategoryUrl($categoryObj);


        return $collecti;
    }
    



    public function getBaseurl()
    {
        return  $this->_storeManager->getStore()->getBaseUrl();

    }

    public function getSchoolId(){
          
          $seller_model = $this->_modelSellerFactory->create();
          $collection = $seller_model->getCollection()->addFieldToFilter('seller_id',$this->getIddata())->getData();
          return $collection[0]['school_id'];
    
    }

   
    public function getFirstName(){

          $seller_model = $this->_modelSellerFactory->create();
          $collection = $seller_model->getCollection()->addFieldToFilter('seller_id',$this->getIddata())->getData();
          return $collection[0]['seller_first_name'];
    
    }

    public function getLastName(){

          $seller_model = $this->_modelSellerFactory->create();
          $collection = $seller_model->getCollection()->addFieldToFilter('seller_id',$this->getIddata())->getData();
          return $collection[0]['seller_last_name'];
    
    }

    public function getEmail(){

          $seller_model = $this->_modelSellerFactory->create();
          $collection = $seller_model->getCollection()->addFieldToFilter('seller_id',$this->getIddata())->getData();
          return $collection[0]['seller_email'];
    
    }

    public function getIddata()
    {
        return $this->request->getParam('id');
    }


    public function getSchoolName(){
          $seller_model = $this->_modelCreateFactory->create();
          $collection = $seller_model->getCollection()->addFieldToFilter('school_id',$this->getSchoolId())->getData();
          return $collection[0]['school_name'];
    }


    protected function _prepareLayout()
    {             
      $this->pageConfig->getTitle()->set(__($this->getSchoolName().'-Thank You For Registering!'));
        return parent::_prepareLayout();
    }




}