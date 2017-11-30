<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-18 02:25:15
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2017-01-05 09:11:37
 */

namespace School\Creation\Controller\Adminhtml\Faq;

use Magento\Framework\Exception\LocalizedException;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'School_Creation::faq_delete';

    /**
     * Delete Question
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                /** @var \Magento\CatalogRule\Model\Rule $model */
                $model = $this->_objectManager->create('School\Creation\Model\Create');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('You deleted the School'));
                $this->_redirect('creation/index/index');
                return;
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('We can\'t delete this school right now. Please review the log and try again.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_redirect('creation/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->messageManager->addError(__('We can\'t find a label to delete.'));
        $this->_redirect('creation/index/index');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */

    }
}
