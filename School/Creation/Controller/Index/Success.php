<?php
 
namespace School\Creation\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use School\Creation\Model\CreateFactory;


 
class Success extends Action
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
    
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}