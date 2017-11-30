<?php
 
namespace School\Creation\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use School\Creation\Model\SellerFactory;


 
class Sellerlogin extends Action
{
    /**
     * @var \Tutorial\SimpleNews\Model\NewsFactory
     */
    protected $_modelNewsFactory;
 
    /**
     * @param Context $context
     * @param NewsFactory $modelNewsFactory
     */
    public function __construct(Context $context,SellerFactory $modelSellerFactory) {
        
        $this->_modelSellerFactory = $modelSellerFactory;
        parent::__construct($context);
    }
 
    public function execute()
    {
        /**
         * When Magento get your model, it will generate a Factory class
         * for your model at var/generaton folder and we can get your
         * model by this way
         */
        $seller_id = $this->getRequest()->getParam('seller_id');





        $seller_model = $this->_modelSellerFactory->create();

        $collection = $seller_model->getCollection()->addFieldToFilter('seller_id',$seller_id);

        
        if($collection->getSize() ==1)
        {

            $this->_redirect('*/index/sellersuccess/*',array('id'=>$seller_id));
            return;
        }
        else
        {
            $this->messageManager->addError(
                             __('Please Enter Correct Student ID'));
            $this->_redirect('*/index/create');
            return;
        }

    }
}
