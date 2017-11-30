<?php
namespace School\Creation\Controller\Index;
class Coordinator extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {

        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}