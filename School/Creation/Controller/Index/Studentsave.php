<?php
 
namespace School\Creation\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use School\Creation\Model\SellerFactory;

use School\Creation\Model\CreateFactory;

use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

 
class Studentsave extends Action
{
    /**
     * @var \Tutorial\SimpleNews\Model\NewsFactory
     */
    protected $_modelNewsFactory;
 
    /**
     * @param Context $context
     * @param NewsFactory $modelNewsFactory
     */
    public function __construct(Context $context,SellerFactory $modelSellerFactory,\Magento\Framework\App\Request\Http $request,StateInterface $inlineTranslation,
TransportBuilder $transportBuilder,ScopeConfigInterface $scopeConfig,CreateFactory $modelCreateFactory
){
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->_modelSellerFactory = $modelSellerFactory;
        $this->_modelCreateFactory = $modelCreateFactory;
        $this->request = $request;

        parent::__construct($context);
    }

    public function getIddata()
    {
    // use 
        $this->request->getParams(); // all params
        return $this->request->getParam('id');
    }
 
    public function execute()
    {
        /**
         * When Magento get your model, it will generate a Factory class
         * for your model at var/generaton folder and we can get your
         * model by this way
         */
        $school_id =  $this->getRequest()->getPost('school_id');
        $seller_fname = $this->getRequest()->getPost('firstname');
        $seller_lname = $this->getRequest()->getPost('lastname');
        $seller_email = $this->getRequest()->getPost('email');
        $seller_id = $this->getRequest()->getPost('seller_id');
        $grade = $this->getRequest()->getPost('grade');
        
        $data = array('seller_id'=> $seller_id,
                      'school_id'=> $school_id,
                      'seller_first_name' => $seller_fname,
                      'seller_last_name' => $seller_lname,
                      'seller_email' => $seller_email,
                      'seller_teacher' => $grade,
                        );




        $school_model = $this->_modelSellerFactory->create();

        $seller_model = $this->_modelCreateFactory->create();

        $seller_model_collection = $seller_model->getCollection()->addFieldToFilter('school_id',$school_id);


        $collection = $school_model->getCollection()->addFieldToFilter('seller_id',$seller_id);

        $email_validation = $school_model->getCollection()->addFieldToFilter('seller_email',$seller_email);



        if($collection->getSize() ==1)
        {
            $this->messageManager->addError(
                        __('Student ID already exist,Please Use Diffent ID'));
            $this->_redirect('*/index/student/');
            return; 
        }
        else if($seller_model_collection->getSize() != 1)
        {
            $this->messageManager->addError(
                        __('Please Enter Valid School ID'));
            $this->_redirect('*/index/student/');
            return; 
        }
        elseif($email_validation->getSize() == 1)
        {
            $this->messageManager->addError(
                        __('Email ID already exist,Please Use Diffent Email ID'));
            $this->_redirect('*/index/student/');
            return; 
        }

        else{

           

        $school_model->setData($data);

        try {
            $school_model->save();
/*            $this->messageManager->addSuccess(
                        __('Student Account Created Successfully.Your Student ID is "'.$seller_id.'"')
                );*/
             $general_email = $this->scopeConfig->getValue('trans_email/ident_support/email',ScopeInterface::SCOPE_STORE);
            $general_name = $this->scopeConfig->getValue('trans_email/ident_support/name',ScopeInterface::SCOPE_STORE);

            $sender = [
            'name' => $general_name,
            'email' => $general_email,
            ];



            $vars = Array('seller_id'=> $seller_id,
                      'school_id'=> $school_id,
                      'seller_name' => $seller_fname.' '.$seller_lname,
                      'seller_email' => $seller_email,
                      'seller_teacher' => $grade,
                        );



            $this->inlineTranslation->suspend();
            $toEmail =$seller_email;
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport = $this->transportBuilder
               ->setTemplateIdentifier('seller_email_template')
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
                        $this->_redirect('*/index/sellersuccess/',array('id'=>$seller_id));
             return;      
           
        }catch (\Exception $e) {
            $this->messageManager->addError(
                        __('We can\'t process your request right now. Sorry, that\'s all we know.'));
                
            }
            $this->_redirect('*/index/student/');
            return;
        }
    }
}
