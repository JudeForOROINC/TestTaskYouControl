<?php

namespace DoublesSearchBundle\Model;

class FileManager {

    protected $bufferLong = 8192;
    protected $silentMode = true;

    const FOLDERS_ARRAY = 'folders';
    const FILES_ARRAY = 'files';
    /**
     * @param $path string path to folder search;
     * @return array
     */
    public function scanFolder($path)
    {
        $dirList = array();
        $fileList = array();
        if ($this->check_path($path)){
            $this->silentMode ? $dir = @scandir($path) : $dir = scandir($path);
            foreach ($dir as $dirname){
                if ( ($dirname == '.' ) or ($dirname == '..') ) continue;
                if ($this->check_path($path.DIRECTORY_SEPARATOR.$dirname)){
                    $dirList[] = $dirname;
                } else {
                    $fileList[] = $dirname;
                }
            }
        }
        return [$this::FOLDERS_ARRAY => $dirList,$this::FILES_ARRAY=>$fileList];
    }

    /**
     * @param $path
     * @return bool
     */
    public function check_path($path)
    {
        if ($this->silentMode) {
            $result = @is_dir($path);
        } else {
            $result = is_dir($path);
        }
        return $result;
    }

    /**
     * @param $file
     * @return bool|int
     */
    public function getFileSize($file)
    {

        if (false !== ($this->silentMode ? $size = @filesize($file) : $size = @filesize($file) )) {
        // may be E_WARNING error. to slience mode use @;
            return $size;
        } else {
            return false;
        }
    }

    /**
     * @param $file1
     * @param $file2
     * @return bool
     */
    public function isIdentical($file1,$file2){
        if(! $f1 = ($this->silentMode ? @fopen($file1,'rb') : fopen($file1,'rb'))){
            return false;
        };
        if(! $f2 = ($this->silentMode ? @fopen($file2,'rb') : fopen($file2,'rb'))){
            fclose($f1);
            return false;
        };

        while ( ! feof($f1)){
            if (false !==( $buf = $this->silentMode ? @fread($f1, $this->bufferLong) : fread($f1, $this->bufferLong) ) ) {
                if (false !==( $buf2 = $this->silentMode ? @fread($f2, $this->bufferLong) : fread($f2, $this->bufferLong) )) {
                    if ( $buf === $buf2) {
                        continue;
                    }
                }

            };
            fclose($f1);
            fclose($f2);
            return false;
        }
        fclose($f1);
        fclose($f2);

        return true;
    }
}

