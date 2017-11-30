<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-17 00:18:36
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2016-12-24 15:23:33
 */

namespace School\Creation\Block\Adminhtml\Faq\Edit\Tab;


class General extends \Magento\Backend\Block\Widget\Form\Generic implements
    \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Active or InActive
     *
     * @var \PHPCuong\Faq\Model\Config\Source\IsActive
     */
    protected $_status;

    /**
     * Yes or No
     *
     * @var \PHPCuong\Faq\Model\Config\Source\Yesno
     */
    protected $_yesNo;

    /**
     * Category
     *
     * @var \PHPCuong\Faq\Model\Config\Source\Category
     */
    protected $_category;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @param \PHPCuong\Faq\Model\Config\Source\Category $category
     * @param \PHPCuong\Faq\Model\Config\Source\Yesno $yesNo
     * @param \PHPCuong\Faq\Model\Config\Source\IsActive $status
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        // \PHPCuong\Faq\Model\Config\Source\Category $category,
        // \PHPCuong\Faq\Model\Config\Source\Yesno $yesNo,
        // \PHPCuong\Faq\Model\Config\Source\IsActive $status,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) {
        //$this->_category = $category;
        //$this->_yesNo    = $yesNo;
        //$this->_status   = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setActive(true);
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('General Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('General Information')]);

        $this->_addElementTypes($fieldset);

       

        $fieldset->addField(
            'school_id',
            'text',
            [
                'name' => 'school_id',
                'label' => __('School ID'),
                'title' => __('School ID'),
                'required' => false
            ]
        );

         $fieldset->addField(
            'school_name',
            'text',
            [
                'name' => 'school_name',
                'label' => __('School Name'),
                'title' => __('School Name'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'school_email',
            'text',
            [
                'name' => 'school_email',
                'label' => __('School Email'),
                'title' => __('School Email'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'school_city',
            'text',
            [
                'name' => 'school_city',
                'label' => __('City'),
                'title' => __('City'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'id',
            'hidden',
            [
                'name' => 'id',
                'label' => __('ID'),
                'title' => __('ID'),
                'required' => false
            ]
        );

        

        $formData = $this->_coreRegistry->registry('creation_faq');
        if ($formData) {
            if ($formData->getFaqId()) {
                $fieldset->addField(
                    'faq_id',
                    'hidden',
                    ['name' => 'faq_id']
                );
            }
            if ($formData->getIsActive() == null) {
                $formData->setIsActive('1');
            }
            $form->setValues($formData->getData());
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
