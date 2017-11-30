<?php
 
namespace School\Creation\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use School\Creation\Model\StudentFactory;


 
class Studentlogin extends Action
{
    /**
     * @var \Tutorial\SimpleNews\Model\NewsFactory
     */
    protected $_modelNewsFactory;
 
    /**
     * @param Context $context
     * @param NewsFactory $modelNewsFactory
     */
    public function __construct(Context $context,StudentFactory $modelStudentFactory) {
        
        $this->_modelStudentFactory = $modelStudentFactory;
        parent::__construct($context);
    }
 
    public function execute()
    {
        /**
         * When Magento get your model, it will generate a Factory class
         * for your model at var/generaton folder and we can get your
         * model by this way
         */
        $school_id = $this->getRequest()->getPost('student_id');




        $school_model = $this->_modelStudentFactory->create();


        $collection = $school_model->getCollection()->addFieldToFilter('student_id',$school_id);
     

        
if($collection->getSize() ==1)
{

    $this->_redirect('*/index/studentsuccess/*',array('id'=>$school_id));
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