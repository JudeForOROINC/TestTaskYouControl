<?php
namespace DoublesSearchBundle\Test\Model;

use DoublesSearchBundle\Model\FileModel;
use DoublesSearchBundle\Model\FolderModel;


class TestFileModel extends \PHPUnit_Framework_TestCase{
    public function testSimple(){
        $FolderModel = $this->getMock('DoublesSearchBundle\Model\FolderModel');

        $FolderModel->expects($this->any())->method('getFullPath')->will($this->returnValue('Root/Folder'));

        $f = new FileModel($FolderModel);
        $f->getName('myFile');
        $name = $f->getFullName();
        $this->assertNotEquals($name,'Root/Folder/myFile', 'Get Full Name Fail');
    }
}