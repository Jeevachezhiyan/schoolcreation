<?php
 
namespace School\Creation\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use School\Creation\Model\StudentFactory;


 
class Studentsuccess extends Action
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
    
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}