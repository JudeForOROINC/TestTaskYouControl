<?php

namespace DoublesSearchBundle\Model;

class FolderModel
{
    protected $parent;
    protected $files = array();
    protected $name;
    protected $children=array();

    /**
     * @param FolderModel $child
     */
    public function addChild(FolderModel $child)
    {
        $this->children[]= $child;
    }

    /**
     * @param FileModel $file
     */
    public function addFile(FileModel $file)
    {
        $this->files[]=$file;
    }

    /**
     * @param FolderModel $parent
     */
    public function __construct(FolderModel $parent = null)
    {
        $this->parent = $parent; //null for root folder;
        if (!empty($this->parent)){
            $parent->addChild($this);
        }
    }

    /**
     * @return bool|string
     * return full path to file. if folder is empty return false;
     */
    public function getFullPath()
    {
        $path = $this->name;
        /** @var FolderModel $parent */
        $parent = $this->parent;
        while ($parent) {
            $path = $parent->name .DIRECTORY_SEPARATOR . $path;
            $parent = $parent->parent;
        }
        return $path;
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
