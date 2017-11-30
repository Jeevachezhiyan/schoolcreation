<?php
namespace School\Creation\Model\ResourceModel;

class Create extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('school_information_table', 'id');
    }
}
?>