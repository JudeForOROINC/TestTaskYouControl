<?php

namespace DoublesSearchBundle\Control;
use DoublesSearchBundle\Model\FileManager;
use DoublesSearchBundle\Model\FileModel;
use DoublesSearchBundle\Model\FolderModel;


class SearchController{
    protected $manager=null;
    protected $root=null;
    protected $filelist = array();

    protected function getManager()
    {
        if (empty($this->manager)){
            $this->manager = new FileManager();
        }
        return $this->manager;
    }

    public function processPath($path){
        $manager = $this->getManager();
        if (! $manager->check_path($path) ){
            throw new \Exception('Wrong directory Path!');
        }

        $this->root = New FolderModel();
        $this->root->setName($path);
        $this->processFolder($this->root);
        $result = $this->searchingDoubles();
        $this->showResult($result);
    }

    protected function processFolder( FolderModel $path){
        $manager = $this->getManager();
        $res =  $manager->scanFolder($path->getFullPath());
        if (count($res[$manager::FOLDERS_ARRAY])>0){
            foreach ($res[$manager::FOLDERS_ARRAY] as $folder) {
                $child = new FolderModel($path);
                $child->setName($folder);
                $this->processFolder($child);
            }
        }
        if (count($res[$manager::FILES_ARRAY])>0){
            foreach ($res[$manager::FILES_ARRAY] as $file) {
                $this->addFile($file,$path);
            }
        }

    }

    protected function addFile($file, FolderModel $path){
        $filemod = new FileModel($path);
        $filemod->setName($file);
        if(false !== ($size = $this->getManager()->getFileSize($filemod->getFullName())) ){
            $this->filelist[$size][]= $filemod;
            $filemod->setSize($size);
        };

    }
    protected function searchingDoubles(){
        $result = array();
        if(count($this->filelist) >0 ) {
            foreach ($this->filelist as $Doubles ){
                $new = $this->processDoubles($Doubles);
                if (count($new)){
                    $result[]=$new;
                }
            }

        }
        return $result;
    }


    protected function processDoubles ($Doubles){
        $result = array();
        while (count($Doubles)>1) {
            /** @var FileModel $main */
            $main = array_pop($Doubles);
            foreach($Doubles as $double){
                if($this->getManager()->isEdentical($main->getFullName(),$double->getFullName())){
                    $result[$main->getFullName()] = $main;
                    $result[$double->getFullName()] = $double;
                };
            }
        }
        //var_dump($result);
        return array_values($result);
    }

    protected function showResult($result){
        foreach ($result as $Line){
            foreach ($Line as $File){
                /** @var FileModel $File */
                print $File->getFullName() . PHP_EOL;
            }
        }
    }
}