<?php
/**
 * Copyright © A2bizz, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace A2bizz\ModuleCreator\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\ObjectManager;
//use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem\DirectoryList;

/**
 * A2bizz ModuleCreator Helper
 *
 */
class Data extends AbstractHelper
{
    private $directoryList;
    private $driverFile;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Driver\File $driverFile     
    ){
        $this->directoryList = $directoryList;  // ?? ObjectManager::getInstance->get(DirectoryList::class);
        $this->driverFile = $driverFile;

        parent::__construct($context);
    }

    public function getMTemplatePath(){
        //echo $rootPath  =  $this->directoryList->getRoot(); // get Project Root Path 
        $pathApp  =  $this->directoryList->getPath('app'); // get Project Root/app/ Path 
        $MTemplatePath = $pathApp.'/code/A2bizz/ModuleCreator/MTemplate/';
        
        return $MTemplatePath;
    }


    public function getAllFilesPath($path = '/var') {
        $paths = [];
        $filePaths = [];
        try {
            //get the base folder path you want to scan (replace var with pub / media or any other core folder)
            $path = $this->getMTemplatePath();
            //read just that single directory
            $paths =  $this->driverFile->readDirectory($path);
            //read all inside folders recursively
            $paths =  $this->driverFile->readDirectoryRecursively($path);
            
            //now seprate those paths which have only files
            foreach ($paths as $p):
                if ($this->driverFile->isFile($p)):
                    $filePaths[]=$p;
                endif;
            endforeach;
        } catch (FileSystemException $e) {
            $this->logger->error($e->getMessage());
        }

        //echo "<pre>";
        //print_r($filePaths);exit;
        
        return $filePaths;
    }

    /*
    * return replaced path for new module to generate inside app/code/
    */
    public function newModuleFiles($data, $filePathsArray){
        $newFilesPathArray = [];
        $namespace = $data['namespace'];
        $module = $data['module'];

        $capNamespace = ucfirst($namespace);
        $lowNamespace = strtolower($namespace);
        $capModule = ucfirst($module);
        $lowModule = strtolower($module);
        
        foreach ($filePathsArray as $filePath):
            $filePath=str_replace("/app/code/A2bizz/ModuleCreator/MTemplate","",$filePath);

            if ($filePath=="/var/www/html/app/code/Namespace/Module/etc/module.xml"):
                $filePath=str_replace("Namespace",$capNamespace,$filePath);
                $filePath=str_replace("Module",$capModule,$filePath);                
            
                $newFilesPathArray[]=$filePath;
                continue;
            endif;
            
            $filePath=str_replace(".a2bizz","",$filePath);
            $filePath=str_replace("Namespace",$capNamespace,$filePath);
            $filePath=str_replace("namespace",$lowNamespace,$filePath);
            $filePath=str_replace("Module",$capModule,$filePath);
            $filePath=str_replace("module",$lowModule,$filePath);

            $newFilesPathArray[]=$filePath;
            //exit;
        endforeach;
                
        //echo "<pre>";
        //print_r($newFilesPathArray);exit;
        //exit;
        return $newFilesPathArray;
    }    
    
    /*
    * This function will copy new module files and folders to app/code/
    */
    public function createFoldersAndCopyBlankoFiles($fromFilesPathArray, $toFilesPathArray){
        try{
            $count=0;
            foreach ($toFilesPathArray as $toFilePath):                
                if (!$this->driverFile->isExists($toFilePath)):
                    $newPath = substr($toFilePath, 0, strrpos($toFilePath, '/'));
                    $this->driverFile->createDirectory($newPath);
                    $this->driverFile->copy($fromFilesPathArray[$count],$toFilesPathArray[$count]);                                        
                endif;
                $count++;
            endforeach;
        } catch (FileSystemException $e) {
            $this->logger->error($e->getMessage());
        }    
        return true;
    }

    public function replaceXml($data,$content){
        $namespace = $data['namespace'];
        $module = $data['module'];

        $capNamespace = ucfirst($namespace);
        $lowNamespace = strtolower($namespace);
        $capModule = ucfirst($module);
        $lowModule = strtolower($module);

        $search = array(
                '/\[Namespace\]/',
                '/\[namespace\]/',
                '/\[Module\]/',
                '/\[module\]/',
            );
            
        $replace = array(
                $capNamespace,
                $lowNamespace,
                $capModule,
                $lowModule,
            );

        return preg_replace($search, $replace, $content);
    }

    public function replacePhp($data,$content){
        $namespace = $data['namespace'];
        $module = $data['module'];

        $capNamespace = ucfirst($namespace);
        $lowNamespace = strtolower($namespace);
        $capModule = ucfirst($module);
        $lowModule = strtolower($module);

        $search = array(
                '/<Namespace>/',
                '/<namespace>/',
                '/<Module>/',
                '/<module>/',
               );

        $replace = array(
                $capNamespace,
                $lowNamespace,
                $capModule,
                $lowModule,
            );

        return preg_replace($search, $replace, $content);
    }

    public function insertVarsInNewCustomModule($data,$toFilesPathArray){
        try{
            foreach($toFilesPathArray as $toFilePath):
                $handle = fopen ($toFilePath, 'r+');
                $content = '';
                while (!feof($handle)) {
                    $content .= fgets($handle);
                }
                fclose($handle);
                
                $type = strrchr($toFilePath, '.');
                switch ($type) {
                    case '.xml':
                        $content = $this->replaceXml($data,$content);
                        break;
                    case '.php':
                    case '.phtml':
                    case '.json':
                    case '.txt':
                    case '.md':    
                        $content = $this->replacePhp($data,$content);
                        break;
                    
                    default:
                        throw new Exception('Unknown file type found: '.$type);
                }
                $handle = fopen ($toFilePath, 'w');
                fputs($handle, $content);    
                fclose($handle);
            endforeach;
        } catch (FileSystemException $e) {
            $this->logger->error($e->getMessage());
        }    
        return true;
    }

    public function createNewModule($data){
        // 1- get File paths from where we are copying files for creating custom Module
        $fromFiles = $this->getAllFilesPath();

        // 2- convert path - Where you want to put new custom module
        // 3- add namespace and module - by which name, new custom module will be added
        $toFiles = $this->newModuleFiles($data,$fromFiles);

        // 4- this function will create folders, on given path for new custom module 
        // 5- also it will paste blanko files - files which we will use to creat custom module
        $this->createFoldersAndCopyBlankoFiles($fromFiles,$toFiles);

        // 6- now this function will read each files and update namespace and modules in the given content
        $this->insertVarsInNewCustomModule($data,$toFiles);
    }
}
