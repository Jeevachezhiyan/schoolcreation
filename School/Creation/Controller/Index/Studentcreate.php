<?php
 
namespace School\Creation\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use School\Creation\Model\StudentFactory;



use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
 
class Studentcreate extends Action
{
    /**
     * @var \Tutorial\SimpleNews\Model\NewsFactory
     */
    protected $_modelNewsFactory;
 
    /**
     * @param Context $context
     * @param NewsFactory $modelNewsFactory
     */
    public function __construct(Context $context,StudentFactory $modelStudentFactory,\Magento\Framework\App\Request\Http $request,StateInterface $inlineTranslation,
TransportBuilder $transportBuilder,ScopeConfigInterface $scopeConfig){

        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        
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
   
        $student_id =  $this->getRequest()->getPost('student_id');
        $student_name = $this->getRequest()->getPost('student_name');
        $student_email = $this->getRequest()->getPost('student_email');
        $school_id = $this->getRequest()->getPost('school_id');
       

        $data = array('school_id'=> $school_id,
                      'student_id'=> $student_id,
                      'student_name' => $student_name,
                      'student_email' => $student_email,
                        );

        $school_model = $this->_modelStudentFactory->create();

        $collection = $school_model->getCollection()->addFieldToFilter('student_id',$student_id);
        $email_validation = $school_model->getCollection()->addFieldToFilter('student_email',$student_email);

        if($collection->getSize() ==1)
        {
            $this->messageManager->addError(
                        __('Student ID already exist,Please Use Diffent ID'));
            $this->_redirect('*/index/success/*',array('id'=>$school_id));
            return; 
        }
        elseif($email_validation->getSize() == 1)
        {
            $this->messageManager->addError(
                        __('Email ID already exist,Please Use Diffent Email ID'));
            $this->_redirect('*/index/success/*',array('id'=>$school_id));
            return; 
        }

        else{
        $school_model->setData($data);

        try {
            $school_model->save();

            $general_email = $this->scopeConfig->getValue('trans_email/ident_support/email',ScopeInterface::SCOPE_STORE);
            $general_name = $this->scopeConfig->getValue('trans_email/ident_support/name',ScopeInterface::SCOPE_STORE);

            $sender = [
            'name' => $general_name,
            'email' => $general_email,
            ];
            $vars = Array('school_id'=> $school_id,
                      'student_id'=> $student_id,
                      'student_name' => $student_name,
                      'student_email' => $student_email,
                        );

            $this->inlineTranslation->suspend();
            $toEmail =$student_email;
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport = $this->transportBuilder
               ->setTemplateIdentifier('student_email_template')
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
                        __('Student Account Created Successfully. Your Student ID is :"'.$student_id.'"')
                );
        }catch (\Exception $e) {
            $this->messageManager->addError(
                        __('We can\'t process your request right now. Sorry, that\'s all we know.'));
                
            }
            $this->_redirect('*/index/success/*',array('id'=>$school_id));
            return;
        }
    }
}
