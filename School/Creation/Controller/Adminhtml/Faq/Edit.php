<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-16 17:33:52
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2016-12-24 17:02:53
 */

namespace School\Creation\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'School_Creation::faq_edit';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {

        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('School_Creation::create');
        return $resultPage;
    }

    /**
     * Edit Question page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('School\Creation\Model\Create');
        $model->setData([]);


        // Initial checking
        if ($id && (int) $id > 0) {
            $model->load($id);
           
            if (!$model->getId()) {
                $this->messageManager->addError(__('This ID is not exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }

            $title = $model->getId();

        }

        $formData = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);

        if (!empty($formData)) {
            $model->setData($formData);
        }

        $this->_coreRegistry->register('creation_faq', $model);



        // Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        
        $this->_initAction();

        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Label Rule'));

        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $model->getRuleId() ? $model->getName() : __('School Creation')
        );
        $breadcrumb = $id ? __('Edit Rule') : __('New Rule');

        $this->_addBreadcrumb($breadcrumb, $breadcrumb);
        $this->_view->renderLayout();

    }
}
