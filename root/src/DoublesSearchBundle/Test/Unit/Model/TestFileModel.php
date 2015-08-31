<?php
namespace DoublesSearchBundle\Test\Unit\Model;

use DoublesSearchBundle\Model\FileModel;
use DoublesSearchBundle\Model\FolderModel;


class TestFileModel extends \PHPUnit_Framework_TestCase{
    public function testSimple(){
        $FolderModel = $this->getMock('DoublesSearchBundle\Model\FolderModel');

        $FolderModel->expects($this->any())->method('getFullPath')->will($this->returnValue('Root/Folder'));

        $f = new FileModel($FolderModel);
        $f->setName('myFile');
        $name = $f->getFullName();
        $this->assertEquals($name,'Root/Folder/myFile', 'Get Full Name Fail');
    }

    /**
     * @param $property
     * @param $value
     * @dataProvider DataProvider
     */
    public function testName($property,$value){
        $FolderModel = $this->getMock('DoublesSearchBundle\Model\FolderModel');
        $FolderModel->expects($this->any())->method('getFullPath')->will($this->returnValue('Root/Folder'));
        $f = new FileModel($FolderModel);
        $setter = 'set'.$property;
        $getter = 'get'.$property;
        $f->$setter($value);

        $this->assertEquals($value,$f->$getter());
    }

    public function DataProvider(){
        return array(
            array('Name','MamaMilaRamu.php'),
            array('Size',100500),
        );
    }
}