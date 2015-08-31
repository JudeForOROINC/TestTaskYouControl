<?php
namespace DoublesSearchBundle\Test\Unit\Model;

use DoublesSearchBundle\Model\FileModel;
use DoublesSearchBundle\Model\FolderModel;


class TestFolderModel extends \PHPUnit_Framework_TestCase{
    public function testSimple(){
        $FolderModel = $this->getMock('DoublesSearchBundle\Model\FolderModel');

        $FolderModel->expects($this->any())->method('getFullPath')->will($this->returnValue('Root/Folder'));

        $f = new FolderModel($FolderModel);
        $f->setName('myFile');
        $name = $f->getFullPath();
        $this->assertNotEquals($name,'Root/Folder/myFile', 'Get Full Name Fail');
    }

    public function testParent(){
        $FolderModel = $this->getMock('DoublesSearchBundle\Model\FolderModel');

        $FolderModel->expects($this->any())->method('getFullPath')->will($this->returnValue('Root/Folder'));

        $f = new FolderModel($FolderModel);
        $f->setName('myFile');
        $p = $f->getParent();

        $this->assertEquals($p->getFullPath(),'Root/Folder');
    }

    /**
     * @param $property
     * @param $value
     * @dataProvider DataProvider
     */
    public function testName($property,$value){
        $f = new FolderModel();
        $setter = 'set'.$property;
        $getter = 'get'.$property;
        $f->$setter($value);

        $this->assertEquals($value,$f->$getter());
    }

    public function DataProvider(){
        return array(
            array('Name','MamaMilaRamu'),
        );
    }
}