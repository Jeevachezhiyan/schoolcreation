<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-17 05:09:06
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2017-01-05 09:10:48
 */

namespace School\Creation\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;



use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;


class Selleremail extends Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
       Context $context,\Magento\Framework\App\Request\Http $request,StateInterface $inlineTranslation,
TransportBuilder $transportBuilder,ScopeConfigInterface $scopeConfig
    ) {
        
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;

        parent::__construct($context);
    }

    public function execute()
    {
        
        $data = $this->getRequest()->getPost();
        $purchase_url = $this->getRequest()->getPost('purchase_url');

        $seller_id = $this->getRequest()->getPost('seller_id');

        $email1 = $this->getRequest()->getPost('message1');
        $email2 = $this->getRequest()->getPost('message2');
        $email3 = $this->getRequest()->getPost('message3');
        $email4 = $this->getRequest()->getPost('message4');
        $email5 = $this->getRequest()->getPost('message5');
        $email6 = $this->getRequest()->getPost('message6');
        $email7 = $this->getRequest()->getPost('message7');
        $email8 = $this->getRequest()->getPost('message8');
        $email9 = $this->getRequest()->getPost('message9');
        $email10 = $this->getRequest()->getPost('message10');

        $subject = $this->getRequest()->getPost('subject');
        $message = $this->getRequest()->getPost('message');
        $sender_name = $this->getRequest()->getPost('firstname').' '.$this->getRequest()->getPost('lastname');
        $sender_email = $this->getRequest()->getPost('email');


         $sender = [
            'name' => $sender_name,
            'email' => $sender_email,
            ];

            $toEmail = array($email1,$email2,$email3,$email4,$email5,$email6,$email7,$email8,$email9,$email10);
            //$toEmail = 'testingteamtest1@gmail.com';

            $vars = Array('purchase_url'=> $purchase_url,
                      'message'=> $message,
                      'subject' => $subject,
                        );



        try{

            $this->inlineTranslation->suspend();
            //$toEmail =$seller_email;
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport = $this->transportBuilder
               ->setTemplateIdentifier('seller_vocher_template')
               ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
               ->setTemplateVars($vars)
               ->setFrom($sender)
               ->addTo($toEmail)
               ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();

            $this->messageManager->addSuccess(
                        __('Mail sent Successfully..')
                );
        }
        catch (\Exception $e) {
            $this->messageManager->addError(
                        __('We can\'t process your request right now. Sorry, that\'s all we know.'));
        }
            $this->_redirect('*/index/sellersuccess/',array('id'=>$seller_id));
            return;
       
    }
    
}
