<?php
 
namespace School\Creation\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use School\Creation\Model\CreateFactory;


use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;


 
class Save extends Action
{
    /**
     * @var \Tutorial\SimpleNews\Model\NewsFactory
     */
    protected $_modelNewsFactory;
 
    /**
     * @param Context $context
     * @param NewsFactory $modelNewsFactory
     */
    public function __construct(Context $context,CreateFactory $modelCreateFactory,StateInterface $inlineTranslation,
TransportBuilder $transportBuilder,ScopeConfigInterface $scopeConfig) {
        
        $this->_modelCreateFactory = $modelCreateFactory;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;

        //$this->_logLoggerInterface = $logLoggerInterface;
        parent::__construct($context);
    }
 
    public function execute()
    {
        /**
         * When Magento get your model, it will generate a Factory class
         * for your model at var/generaton folder and we can get your
         * model by this way
         */
        $school_name = $this->getRequest()->getPost('firstname');
        $email = $this->getRequest()->getPost('email');
        $phone = $this->getRequest()->getPost('phone');
        $fax = $this->getRequest()->getPost('fax');
        $address = $this->getRequest()->getPost('address');
        $state = $this->getRequest()->getPost('state');
        $zipcode = $this->getRequest()->getPost('zipcode');
        $name = $this->getRequest()->getPost('name');
        $typeoffund = $this->getRequest()->getPost('typeoffund');
        $comment = $this->getRequest()->getPost('comment');
        $city = $this->getRequest()->getPost('school_city');


        $school_model = $this->_modelCreateFactory->create();

        $collection = $school_model->getCollection()->addFieldToFilter('school_email',$email);
        

        if($collection->getSize() >0)
        {

            $this->_redirect('*/index/index/*');
            $this->messageManager->addError(
                        __('Email ID already exist'));
            return;
        }  
        else
        {
            $data = array('school_id'=>'',
                          'school_name' => $school_name,
                          'school_email' => $email,
                          'school_city' => $city,
                          'phone' => $phone,
                          'zipcode'=>$zipcode,
                          'fax' => $fax,
                          'address' => $address,
                          'state' => $state,
                          'name' => $name,
                          'typeoffund' => $typeoffund,
                          'comment' => $comment
                            );
            $school_model->setData($data);

            try {
                $school_model->save();
               

   $general_email = $this->scopeConfig->getValue('trans_email/ident_support/email',ScopeInterface::SCOPE_STORE);
                $general_name = $this->scopeConfig->getValue('trans_email/ident_support/name',ScopeInterface::SCOPE_STORE);

                $sender = [
                'name' => $general_name,
                'email' => $general_email,
                ];
                $vars = Array(
                      'school_name' => $school_name,
                        );

                  $this->inlineTranslation->suspend();
       


            $transport = $this->transportBuilder
               ->setTemplateIdentifier('schoolfirst_email_template')
               ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
               ->setTemplateVars($vars)
               ->setFrom($sender)
               ->addTo($email)
               ->getTransport();
            $transport->sendMessage();
            
            $this->inlineTranslation->resume();
             
      

  $this->messageManager->addSuccess(
                            __('Thanks for Submission You will receive School ID through Your Mail after admin Approval.')
                    );

               
            }catch (\Exception $e) {

                $this->messageManager->addError(
                            __('We can\'t process your request right now. Sorry, that\'s all we know.'));
                    
                }
            $this->_redirect('*/*/');
            return;
     }
    }
}