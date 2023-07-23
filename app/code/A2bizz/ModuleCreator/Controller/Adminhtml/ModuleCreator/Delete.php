<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace A2bizz\ModuleCreator\Controller\Adminhtml\ModuleCreator;

class Delete extends \A2bizz\ModuleCreator\Controller\Adminhtml\ModuleCreator
{
    protected $dataPersistor;
    protected $fullModuleList;
    protected $_moduleManager;
    protected $helper;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\Module\FullModuleList $fullModuleList,
        \Magento\Framework\Module\Manager $moduleManager,
        \A2bizz\ModuleCreator\Helper\Delete $helper
    ) {
        $this->fullModuleList = $fullModuleList;
        $this->_moduleManager = $moduleManager;
        $this->helper = $helper;

        parent::__construct($context,$coreRegistry);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('modulecreator_id');
        if ($id) {
            try {
                
                // init model and delete
                $model = $this->_objectManager->create(\A2bizz\ModuleCreator\Model\ModuleCreator::class);
                
                //Delete Module Files and Tables
                $this->deleteModule($id);

                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the ModuleCreator.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['modulecreator_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a ModuleCreator to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * deleteModule method
     *
     * @return void delete a module inside "app/code"
     * it will delete module only which is being created by ModuleCreator
     */
    public function deleteModule($id){
        $this->helper->deleteModule($id);
    }
}

