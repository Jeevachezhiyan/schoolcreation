<?php
namespace School\Creation\Observer;
use Magento\Sales\Model\Order;
use School\Creation\Controller\Index\Registerseller;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Stdlib\Cookie\PublicCookieMetadata;
use Magento\Framework\Stdlib\CookieManagerInterface;



class School implements \Magento\Framework\Event\ObserverInterface
{

	public function __construct(
        \Magento\Framework\Registry $registry,Registerseller $index, \Magento\Framework\App\Action\Context $context,
        CookieManagerInterface $cookieManager,
        CookieMetadataFactory $cookieMetadataFactory,
        SessionManagerInterface $sessionManager)
    {
         $this->registry = $registry;
        $this->_cookieManager = $cookieManager;
        $this->_cookieMetadataFactory = $cookieMetadataFactory;
        $this->_sessionManager = $sessionManager;
         //parent::__construct($context);
  	}

	public function execute(\Magento\Framework\Event\Observer $observer)
  	{ 
  	    	$orderId = $observer->getEvent()->getOrderIds();
  	    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		   $order = $objectManager->create('\Magento\Sales\Model\Order') ->load($orderId[0]);
	        // $order = $observer->getOrder();		
                 $order->setSchoolId($this->getSchoolId())
                ->setSellerId($this->getSellerId())
                ->setSchoolName($this->getSchoolName())
                ->setSellerName($this->getSellerName());
			$order->save();
			return true;    
  	}
  

  public function getSellerId()
	{
     		return $this->_cookieManager->getCookie('seller_id');
	}

	public function getSchoolId()
  {
     	  return $this->_cookieManager->getCookie('school_id');
  }
    
  public function getSellerName()
	{
     	 return $this->_cookieManager->getCookie('seller_name');
	}

	public function getSchoolName()
    {
     	 return $this->_cookieManager->getCookie('school_name');

    }
}
