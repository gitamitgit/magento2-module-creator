<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace A2bizz\ModuleCreator\Controller\Adminhtml\ModuleCreator;

class Index extends \Magento\Backend\App\Action
{

    protected $_moduleManager;
    protected $fullModuleList;
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Framework\Module\FullModuleList $fullModuleList,
        \A2bizz\ModuleCreator\Model\ModuleCreator $model,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->_moduleManager = $moduleManager;
        $this->fullModuleList = $fullModuleList;
        $this->model = $model;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        //update module status of those modules created using module creator, 
        //if any module is enabled/ disabled in project
        $this->updateModulesStatus();
        //exit;

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__("ModuleCreator"));
        
        return $resultPage;
    }
        
    public function updateModulesStatus(){                
        foreach( $this->model->getCollection() as $row ){
            $moduleName=$row->getNamespace().'_'.$row->getModule();
            if( $this->_moduleManager->isEnabled($moduleName) ):
                $row->setIsActive(1);
                $row->save();
            else:
                $row->setIsActive(0);
                $row->save();
            endif;
        }        
    }
}

