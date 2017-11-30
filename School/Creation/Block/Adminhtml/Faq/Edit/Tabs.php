<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-17 00:14:40
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2016-12-19 21:29:23
 */

namespace School\Creation\Block\Adminhtml\Faq\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * Internal constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('creation_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('School Information'));
    }

    protected function _beforeToHtml()
    {
        $this->setActiveTab('general_section');
        return parent::_beforeToHtml();
    }
}
