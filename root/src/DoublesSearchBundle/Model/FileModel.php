<?php
namespace DoublesSearchBundle\Model;

use DoublesSearchBundle\Model\FileManager;

class FileModel{
    /** @var FileManager $folder */
    protected $folder = null;
    protected $name;
    protected $size = null;

    /**
     * @return bool|string
     * return full path to file. if folder is empty return false;
     */
    public function getFullName(){
        if ($this->folder) {
            return $this->folder->getFullPath() . DIRECTORY_SEPARATOR . $this->name;
        }
        return false;
    }

    public function __construct(FolderModel $folder){
        $this->folder = $folder;
        if (!empty($this->folder)){
            $folder->addFile($this);
        }
    }

    /**
     * @return int|null
     * Return size of file from "cache" or read from disk
     *
     */
    public function getSize(){
        return $this->size;
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

    /**
     * @param null $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }
}
