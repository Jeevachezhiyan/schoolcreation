<?php
namespace School\Creation\Ui\Component\Listing\Column;

use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Framework\Api\SearchCriteriaBuilder;
use School\Creation\Model\CreateFactory;


class Status extends Column
{
    protected $_orderRepository;
    protected $_searchCriteria;

    public function __construct(ContextInterface $context, UiComponentFactory $uiComponentFactory, OrderRepositoryInterface $orderRepository, SearchCriteriaBuilder $criteria, array $components = [], array $data = [],CreateFactory $modelCreateFactory)
    {
        $this->_orderRepository = $orderRepository;
        $this->_modelCreateFactory = $modelCreateFactory;
        $this->_searchCriteria  = $criteria;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {

                $order  = $this->_orderRepository->get($item["entity_id"]);
           
                $school_name = $order->getData('school_name');
                $seller__name = $order->getData('seller_name');

                // $school_model = $this->_modelCreateFactory->create();


                // $collection = $school_model->getCollection()->getData();
                // print_r($order->getData());
                // die();

                // $collection = $school_model->getCollection()->addFieldToFilter('school_id',$school_id)->getData();
         
                // $school_name = $collection[0]['school_name']; 

                //$collection = $seller_model->getCollection()->addFieldToFilter('seller_id',$this->getIddata())->getData();

                if(empty($school_name))
                {
                    $item[$this->getData('name')] = 'Default';
                }
                else
                {
                    $item[$this->getData('name')] = $school_name;
                }

                // switch ($status) {
                //     case "0":
                //         $export_status = "No";
                //         break;
                //     case "1";
                //         $export_status = "Yes";
                //         break;
                //     default:
                //         $export_status = "Failed";
                //         break;

                // }

                // $this->getData('name') returns the name of the column so in this case it would return export_status
                
            }
        }

        return $dataSource;
    }
}


?>
