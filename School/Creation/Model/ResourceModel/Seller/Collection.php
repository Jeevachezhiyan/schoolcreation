<?php

namespace School\Creation\Model\ResourceModel\Seller;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('School\Creation\Model\Seller', 'School\Creation\Model\ResourceModel\Seller');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>