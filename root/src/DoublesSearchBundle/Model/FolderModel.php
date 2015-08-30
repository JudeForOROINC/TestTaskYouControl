<?php

namespace DoublesSearchBundle\Model;

class FolderModel{
    protected $parent;
    protected $files = array();
    protected $name;
    protected $children=array();

    public function addChild(FolderModel $child){
        $this->children[]= $child;
    }

    public function addFile(FileModel $file){
        $this->files[]=$file;
    }

    public function __constructor(FolderModel $parent = null){
        $this->parent = $parent; //null for root folder;
        if (!empty($this->parent)){
            $parent->addChild($this);
        }
    }

    /**
     * @return bool|string
     * return full path to file. if folder is empty return false;
     */
    public function getFullPath(){
        $path = $this->name;
        /** @var FolderModel $parent */
        $parent = $this->parent;
        while ($parent){
            $path = $parent->name . $path;
            $parent = $parent->parent;
        }
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function searchFolder($path)
    {
        $dirList = array();
        if (is_dir($path)){
            $dir = scandir($path);
            foreach ($dir as $dirname){
                if ( ($dirname == '.' ) or ($dirname == '..') ) continue;
                if ($this->check_path($path.DIRECTORY_SEPARATOR.$dirname)){
                    $dirList[] = $dirname;
                } else {
                    add_file($path.DIRECTORY_SEPARATOR.$dirname);
                }
            }
        }
        return $dirList;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}