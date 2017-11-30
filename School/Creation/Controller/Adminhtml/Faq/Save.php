<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-17 05:09:06
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2017-01-05 09:10:48
 */

namespace School\Creation\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;
use School\Creation\Model\CreateFactory;


use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;


class Save extends \Magento\Backend\App\Action
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
        Context $context,
        \Magento\Framework\Registry $coreRegistry,CreateFactory $modelCreateFactory,StateInterface $inlineTranslation,
TransportBuilder $transportBuilder,ScopeConfigInterface $scopeConfig
    ) {


        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
    	$this->_modelCreateFactory = $modelCreateFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();



        if ($data) {

            $id = $data['id'];


            /** @var \PHPCuong\Faq\Model\Faq $model */

            if(empty($id))
            {

            	$model = $this->_modelCreateFactory->create();
            	$data = array('school_id'=>$data['school_id'],
                      'school_name' => $data['school_name'],
                      'school_email' => $data['school_email'],
                      'school_city' => $data['school_city'],
                        );

            	$school_model = $this->_modelCreateFactory->create();

            	$collection = $school_model->getCollection()->addFieldToFilter('school_id',$data['school_id']);

            	$school_email = $school_model->getCollection()->addFieldToFilter('school_email',$data['school_email']);

            	if($collection->getSize() ==1)
				{
					$this->messageManager->addError('School ID already exist please use diffent ID');
					return $resultRedirect->setPath('creation/faq/new/');
				}
				else if ($school_email ->getSize() == 1) {
					$this->messageManager->addError('School email already exist please use diffent email');
					return $resultRedirect->setPath('creation/faq/new/');
				}
				else
				{	

					$school_model->setData($data);
	        		$school_model->save();

                    $general_email = $this->scopeConfig->getValue('trans_email/ident_support/email',ScopeInterface::SCOPE_STORE);
                    $general_name = $this->scopeConfig->getValue('trans_email/ident_support/name',ScopeInterface::SCOPE_STORE);

                    $sender = [
                        'name' => $general_name,
                        'email' => $general_email,
                    ];
                    $vars = Array('school_id'=>$data['school_id'],
                      'school_name' => $data['school_name'],
                      'school_email' => $data['school_email'],
                      'school_city' => $data['school_city'],
                        );

                    $this->inlineTranslation->suspend();
                    $toEmail =$data['school_email'];
                    $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                    $transport = $this->transportBuilder
                       ->setTemplateIdentifier('school_email_template')
                       ->setTemplateOptions(
                            [
                                'area' => \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
                                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                            ]
                        )
                       ->setTemplateVars($vars)
                       ->setFrom($sender)
                       ->addTo($toEmail)
                       ->getTransport();
                    $transport->sendMessage();
                    $this->inlineTranslation->resume();


    	    		$this->messageManager->addSuccess(__('School Information Updated Successfully.'));
        			return $resultRedirect->setPath('creation/index/index');
				}

        		
            }
            else
            {
            	$model = $this->_objectManager->create('School\Creation\Model\Create')->load($id);
            	$collection = $model->getCollection()->addFieldToFilter('school_id',$data['school_id']);

            	$school_email = $model->getCollection()->addFieldToFilter('school_email',$data['school_email']);

    //         	if($collection->getSize() ==1)
				// {
				// 	$this->messageManager->addError('School ID already exist please use diffent ID');
				// 	return $resultRedirect->setPath('creation/faq/edit', ['id' => $model->getId()]);
				// }
				// if ($school_email->getSize() == 1) {
				// 	$this->messageManager->addError('School Email already exist please use diffent Email');
				// 	return $resultRedirect->setPath('creation/faq/edit', ['id' => $model->getId()]);
				// }

            }


            
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This School no longer exists.'));
                return $resultRedirect->setPath('creation/faq/new/');
            }

           
        
            // $this->_eventManager->dispatch(
            //     'faq_faq_prepare_save',
            //     ['faq' => $model, 'request' => $this->getRequest()]
            // );

            try {
            	 	$model->setData($data);
                	$model->save();
                     $general_email = $this->scopeConfig->getValue('trans_email/ident_support/email',ScopeInterface::SCOPE_STORE);
                    $general_name = $this->scopeConfig->getValue('trans_email/ident_support/name',ScopeInterface::SCOPE_STORE);

                    $sender = [
                        'name' => $general_name,
                        'email' => $general_email,
                    ];
                    $vars = Array('school_id'=>$data['school_id'],
                      'school_name' => $data['school_name'],
                      'school_email' => $data['school_email'],
                      'school_city' => $data['school_city'],
                        );

                    $this->inlineTranslation->suspend();
                    $toEmail =$data['school_email'];
                    $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                    $transport = $this->transportBuilder
                       ->setTemplateIdentifier('school_email_template')
                       ->setTemplateOptions(
                            [
                                'area' => \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
                                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                            ]
                        )
                       ->setTemplateVars($vars)
                       ->setFrom($sender)
                       ->addTo($toEmail)
                       ->getTransport();
                    $transport->sendMessage();
                    $this->inlineTranslation->resume();
                $this->messageManager->addSuccess(__('School Information Updated Successfully.'));

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('creation/faq/edit', ['id' => $model->getId()]);
                }
                return $resultRedirect->setPath('creation/index/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the School.'));
                // $this->messageManager->addError($e->getMessage());
            }

            $this->_getSession()->setFormData($data);
            if ($this->getRequest()->getParam('id')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
            return $resultRedirect->setPath('*/*/new');
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Check if admin has permissions to visit related pages.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        if ($this->_authorization->isAllowed('School_Creation::faq_edit') || $this->_authorization->isAllowed('School_Creation::faq_create')) {
            return true;
        }
        return false;
    }
}
