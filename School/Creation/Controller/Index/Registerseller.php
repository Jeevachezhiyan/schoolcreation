<?php


namespace School\Creation\Controller\Index;

use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Stdlib\Cookie\PublicCookieMetadata;
use Magento\Framework\Stdlib\CookieManagerInterface;


//ini_set("display_errors",1);

class Registerseller extends \Magento\Framework\App\Action\Action
{
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $registry,CookieManagerInterface $cookieManager,
        CookieMetadataFactory $cookieMetadataFactory,
        SessionManagerInterface $sessionManager
        )
    {
        $this->registry = $registry;

        $this->_cookieManager = $cookieManager;
        $this->_cookieMetadataFactory = $cookieMetadataFactory;
        $this->_sessionManager = $sessionManager;

        
        return parent::__construct($context);
    }
      
    public function execute()
    {
    	
    	$seller_id = $this->getRequest()->getParam('seller_id');
    	$school_name = $this->getRequest()->getParam('school_name');
    	$seller_name = $this->getRequest()->getParam('seller_name');
    	$school_id = $this->getRequest()->getParam('school_id');
        $category_id = $this->getRequest()->getParam('category_id');                                        
                                        

     	$this->registry->register('seller_id',$seller_id);
     	$this->registry->register('school_name',$school_name);
     	$this->registry->register('school_id',$school_id);
     	$this->registry->register('seller_name',$seller_name);
        $this->registry->register('category_id',$category_id);


        $this->deleteCookie();
        $this->setCookie();
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
     	//$this->_redirect('customer/account/login/');      
    }


    public function deleteCookie()
    {
        
        $duration = '86400';

        $this->_cookieManager->deleteCookie(
            'seller_id',
            $this->_cookieMetadataFactory
                ->createCookieMetadata()
                ->setPath($this->_sessionManager->getCookiePath())
                ->setDomain($this->_sessionManager->getCookieDomain())
        );

        $this->_cookieManager->deleteCookie(
            'school_id',
            $this->_cookieMetadataFactory
                ->createCookieMetadata()
                ->setPath($this->_sessionManager->getCookiePath())
                ->setDomain($this->_sessionManager->getCookieDomain())
        );

        $this->_cookieManager->deleteCookie(
            'seller_name',
            $this->_cookieMetadataFactory
                ->createCookieMetadata()
                ->setPath($this->_sessionManager->getCookiePath())
                ->setDomain($this->_sessionManager->getCookieDomain())
        );

        $this->_cookieManager->deleteCookie(
            'school_name',
            $this->_cookieMetadataFactory
                ->createCookieMetadata()
                ->setPath($this->_sessionManager->getCookiePath())
                ->setDomain($this->_sessionManager->getCookieDomain())
        );
        $this->_cookieManager->deleteCookie(
            'category_id',
            $this->_cookieMetadataFactory
                ->createCookieMetadata()
                ->setPath($this->_sessionManager->getCookiePath())
                ->setDomain($this->_sessionManager->getCookieDomain())
        );

        return true;

    }

    public function setCookie()
    {

         $duration = '86400';

         $metadata = $this->_cookieMetadataFactory
            ->createPublicCookieMetadata()
            ->setDuration($duration)
            ->setPath($this->_sessionManager->getCookiePath())
            ->setDomain($this->_sessionManager->getCookieDomain());
 
        $this->_cookieManager->setPublicCookie(
            'seller_id',
            $this->getSellerId(),
            $metadata
        );


        $this->_cookieManager->setPublicCookie(
            'school_id',
            $this->getSchoolId(),
            $metadata
        );


        $this->_cookieManager->setPublicCookie(
            'seller_name',
            $this->getSellerName(),
            $metadata
        );


        $this->_cookieManager->setPublicCookie(
            'school_name',
            $this->getSchoolName(),
            $metadata
        );

        $this->_cookieManager->setPublicCookie(
            'category_id',
            $this->getCategoryId(),
            $metadata
        );
        return true;

    }


    public function getCategoryId()
    {
        return $this->registry->registry('category_id');
    }

    public function getSellerId()
    {
            return $this->registry->registry('seller_id');
    }

    public function getSchoolId()
    {
        return $this->registry->registry('school_name');
    }
    
    public function getSellerName()
    {
        return $this->registry->registry('seller_id');
    }

    public function getSchoolName()
    {
        return $this->registry->registry('school_name');

    }
}
