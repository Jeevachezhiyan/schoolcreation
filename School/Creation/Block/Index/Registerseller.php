<?php


namespace School\Creation\Block\Index;

use Magento\Framework\View\Element\Template;

class Registerseller extends \Magento\Catalog\Block\Category\View
{
    protected $_coreRegistry = null;
    
    public function __construct(
        Template\Context $context, 
        \Magento\Catalog\Model\Layer\Resolver $layerResolver, 
        \Magento\Framework\Registry $registry, 
        \Magento\Catalog\Helper\Image $image,    
        \Magento\Catalog\Helper\Category $categoryHelper, 
        \Magento\Catalog\Model\CategoryFactory  $categoryFactory,
        array $data = array(),\Magento\Framework\App\Request\Http $request) 
    {   
        parent::__construct($context, $layerResolver, $registry, $categoryHelper,$data);
        $this->request = $request;
        $this->_categoryFactory = $categoryFactory;
        $this->image = $image;
     }

    public function getCategoryList()
    {
      $_category  = $this->getCurrentCategory();
      $collection = $this->_categoryFactory->create()->getCollection()->addAttributeToSelect('*')
              ->addAttributeToFilter('is_active', 1)
              ->addAttributeToFilter('entity_id',array('in'=>array($this->getIddata())))
              ->setOrder('position', 'ASC');
      return $collection;
      
    }

    public function getIddata()
    {
        return $data=explode(",",$this->request->getParam('category_id'));
    }

    public function getCategoryThumbImage($imageName) {
          $mediaDirectory = $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            );
        return  $mediaDirectory.'catalog/category/'.$imageName;
       
    }
  

    public function getPlaceholderImage(){
        return $this->image->getPlaceholder('image');
    }

}
