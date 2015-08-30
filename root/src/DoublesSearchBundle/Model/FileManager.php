<?php

namespace DoublesSearchBundle\Model;

class FileManager {

    protected $bufferLong = 8192;
    protected $silentMode = true;

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
        return ['folders' => $dirList,'files'=>$fileList];
    }

    public function check_path($path)
    {
        if ($this->silentMode) {
            $result = @is_dir($path);
        } else {
            $result = is_dir($path);
        }
        return $result;
    }

    public function getFileSize($file)
    {

        if (false !== ($this->silentMode ? $size = @filesize($file) : $size = @filesize($file) )) {
        // may be E_WARNING error. to slience mode use @;
            return $size;
        } else {
            return false;
        }
    }

    public function isEdentical($file1,$file2){
        if(! $this->silentMode ?  $f1 = @fopen($file1,'rb') : $f1 = fopen($file1,'rb')){
            return false;
        };
        if(! $this->silentMode ? $f2 = @fopen($file2,'rb') : $f2 = fopen($file2,'rb')){
            fclose($f1);
            return false;
        };

        while ( ! feof($f1)){
            if (false !==( $buf = $this->silentMode ? @fread($f1, $this->bufferLong) : fread($f1, $this->bufferLong) ) ) {
                if (false !==( $buf2 = $this->silentMode ? @fread($f2, $this->bufferLong) : fread($f2, $this->bufferLong) )) {
                    if (! $buf xor $buf2) {
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

