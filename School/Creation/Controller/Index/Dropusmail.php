<?php
 
namespace School\Creation\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;


use Magento\Framework\App\RequestInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;


class Dropusmail extends Action
{
    /**
     * @var \Tutorial\SimpleNews\Model\NewsFactory
     */
    
 
    /**
     * @param Context $context
     * @param NewsFactory $modelNewsFactory
     */
    public function __construct(Context $context,CreateFactory $modelCreateFactory,StateInterface $inlineTranslation,
TransportBuilder $transportBuilder,ScopeConfigInterface $scopeConfig) {

        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;

        parent::__construct($context);
    }
 
    public function execute()
    {
        /**
         * When Magento get your model, it will generate a Factory class
         * for your model at var/generaton folder and we can get your
         * model by this way
         */
        $name = $this->getRequest()->getPost('name');
        $email = $this->getRequest()->getPost('email');
        $message = $this->getRequest()->getPost('message');
        $phone = $this->getRequest()->getPost('phone');
        $url = $this->getRequest()->getPost('url');
        try {
            
            //$general_email = $this->scopeConfig->getValue('trans_email/ident_support/email',ScopeInterface::SCOPE_STORE);
            $general_email = 'testingteamtest3@gmail.com';
            $sender = [
            'name' => '',
            'email' => $email,
            ];
            $vars = Array('name' => $name,'email'=>$email,'message'=>$message,'phone'=>$phone);
            $this->inlineTranslation->suspend();
            $toEmail =$general_email;
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport = $this->transportBuilder
               ->setTemplateIdentifier('dropus_email_template')
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
                            __('Thanks for Your Submission')
                    );
        }catch (\Exception $e) {
            $this->messageManager->addError(
                        __('We can\'t process your request right now. Sorry, that\'s all we know.'));
                
            }
        $this->_redirect($url);
        return;
    }
}