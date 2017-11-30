<?php
 
namespace School\Creation\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use School\Creation\Model\CreateFactory;


 
class Schoollogin extends Action
{
    /**
     * @var \Tutorial\SimpleNews\Model\NewsFactory
     */
    protected $_modelNewsFactory;
 
    /**
     * @param Context $context
     * @param NewsFactory $modelNewsFactory
     */
    public function __construct(Context $context,CreateFactory $modelCreateFactory) {
        
        $this->_modelCreateFactory = $modelCreateFactory;
        parent::__construct($context);
    }
 
    public function execute()
    {
        /**
         * When Magento get your model, it will generate a Factory class
         * for your model at var/generaton folder and we can get your
         * model by this way
         */
        $school_id = $this->getRequest()->getPost('school_id');
        $coordinator = $this->getRequest()->getPost('coordinator');

        $school_model = $this->_modelCreateFactory->create();


        $collection = $school_model->getCollection()->addFieldToFilter('school_id',$school_id);
     

        
if($collection->getSize() ==1)
{
    if($coordinator == 1)
    {
        $this->_redirect('*/index/coordinatorsuccess/*',array('id'=>$school_id));
        return;
    }
    else
    {
        $this->_redirect('*/index/success/*',array('id'=>$school_id));
        return;
    }
}
else
{
    if($coordinator == 1)
    {
        $this->messageManager->addError(
                     __('Please Enter Correct Coordinator ID'));
        $this->_redirect('*/index/coordinator');
        return;

    }
    else{
        $this->messageManager->addError(
                     __('Please Enter Correct School ID'));
        $this->_redirect('*/index/create');
        return;
    }
}

    }
}
