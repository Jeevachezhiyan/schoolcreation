<?php

namespace School\Creation\Model\ResourceModel\Create;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('School\Creation\Model\Create', 'School\Creation\Model\ResourceModel\Create');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>