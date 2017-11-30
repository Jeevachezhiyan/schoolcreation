<?php
namespace School\Creation\Model;

class Student extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('School\Creation\Model\ResourceModel\Student');
    }
}
?>