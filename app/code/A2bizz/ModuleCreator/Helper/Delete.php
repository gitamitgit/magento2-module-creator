<?php
/**
 * Copyright © A2bizz, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace A2bizz\ModuleCreator\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Filesystem\DirectoryList;

/**
 * A2bizz ModuleCreator Helper
 *
 */
class Delete extends AbstractHelper
{
    private $directoryList;
    private $driverFile;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Driver\File $driverFile,
        \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup,
        \A2bizz\ModuleCreator\Model\ModuleCreator $model  
    ){
        $this->directoryList = $directoryList;
        $this->driverFile = $driverFile;
        $this->schemaSetup = $schemaSetup;        
        $this->model = $model;

        parent::__construct($context);
    }

    public function getModuleNameById($id){
        $model = $this->model->load($id);
        $moduleName=$model->getNamespace().'_'.$model->getModule();
        return $moduleName;
        //echo "<pre>";
        //print_r($moduleName);
        //exit;
    }

    public function deleteModule($id){
        
        $model = $this->model->load($id);
        $namespace=$model->getNamespace();
        $module=$model->getModule();

        //generate path for module, which you want to delete
        $pathApp  =  $this->directoryList->getPath('app'); // get Project Root/app/ Path 
        $namespacePath=$pathApp.'/code/'.$namespace.'/';
        $modulePath=$pathApp.'/code/'.$namespace.'/'.$module.'/';
        
        //count number of child directories in a namespace, 
        //so that if there is only single module then it should have to remove whole namespace directlory with module directory
        $totalChildDirectories = count( glob($namespacePath.'*', GLOB_ONLYDIR) );
        if( $totalChildDirectories > 1 ):
            if( $this->driverFile->isExists($modulePath) ):
                //remove dirctory recursively of the module
                $this->driverFile->deleteDirectory($modulePath);
            endif;
        else:
            if( $this->driverFile->isExists($namespacePath) ):
                //remove dirctory recursively of the namespace with single module
                $this->driverFile->deleteDirectory($namespacePath);
            endif;
        endif;

        //delete corresponding table generated for module
        // Table geenrated will always have name in lowercase "namespace_module" Format
        $this->deleteModuleTable(strtolower($namespace.'_'.$module));
    }

    public function deleteModuleTable($tableName){
        $installer = $this->schemaSetup;
        $installer->startSetup();
        
        if ($installer->tableExists($tableName)) {            
            $installer->getConnection()->dropTable($installer->getTable($tableName));
        }

        $installer->endSetup();
    }
}