<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace A2bizz\ModuleCreator\Controller\Adminhtml\ModuleCreator;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;
    protected $fullModuleList;
    protected $_moduleManager;
    protected $helper;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\Module\FullModuleList $fullModuleList,
        \Magento\Framework\Module\Manager $moduleManager,
        \A2bizz\ModuleCreator\Helper\Data $helper
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->fullModuleList = $fullModuleList;
        $this->_moduleManager = $moduleManager;
        $this->helper = $helper;

        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            
            $id = $this->getRequest()->getParam('modulecreator_id');
        
            $model = $this->_objectManager->create(\A2bizz\ModuleCreator\Model\ModuleCreator::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This ModuleCreator no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            //echo "<pre>";
            //print_r($model->getData());
            //exit;

            //this methods checks weather the module is already been created in Magento setup            
            if($this->isModuleAlreadyCreated($data)){
                //echo "IF";exit;
                $this->messageManager->addErrorMessage(__('This Module Already exists.'));
                if(!$id){                    
                    return $resultRedirect->setPath('*/*/new');
                } else {
                    return $resultRedirect->setPath('*/*/edit', ['modulecreator_id' => $this->getRequest()->getParam('modulecreator_id')]);
                }                
            } else {
                //echo "Else";
                //var_dump($id);
                //exit;
                if (!$model->getId()) {
                    // this will create a new module inside app/code/ with namespace_module name 
                    $this->createNewModule($data);
                } 
            }            
            $model->setData($data);
        
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the ModuleCreator.'));
                $this->dataPersistor->clear('a2bizz_modulecreator');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['modulecreator_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the ModuleCreator.'));
            }
        
            $this->dataPersistor->set('a2bizz_modulecreator', $data);
            return $resultRedirect->setPath('*/*/edit', ['modulecreator_id' => $this->getRequest()->getParam('modulecreator_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }


    /**
     * createModule method
     *
     * @return void create a new module inside app/code
     */
    public function createNewModule($data){
        $this->helper->createNewModule($data);
    }

    /**
     * isModuleAlreadyCreated method
     *
     * @return true if module is already avaiable in magento setup
     */
    
    public function isModuleAlreadyCreated($data){

        //print_r($data);exit;

        $newModule=$data['namespace'].'_'.$data['module'];
        $allModules = $this->fullModuleList->getAll($newModule);

        //echo "<pre>";print_r($allModules);exit;
        
        //If Module is saved already
        if( isset($data['modulecreator_id'])):
            /*
            $count=0;
            foreach ( $allModules as $module ):
                if( $newModule==$module['name'] ):
                    $count++;
                endif;
            endforeach;
            if($count>0):
                return true;
            endif;
            */            
        else:
            foreach ( $allModules as $module ):
                if( $newModule==$module['name'] ):
                    //$this->messageManager->addErrorMessage(__('This Module Already exists.'));
                    //return $resultRedirect->setPath('*/*/new');
                    return true;
                endif;
            endforeach;
            return false;
            //$this->createNewModule($data);
        endif;

    }
}

