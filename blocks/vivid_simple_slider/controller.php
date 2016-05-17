<?php
namespace Concrete\Package\VividSimpleSlider\Block\VividSimpleSlider;
use \Concrete\Core\Block\BlockController;
use Loader;
use File;

class Controller extends BlockController
{
    protected $btTable = 'btVividSimpleSlider';
    protected $btInterfaceWidth = "650";
    protected $btWrapperClass = 'ccm-ui';
    protected $btInterfaceHeight = "465";

    public function getBlockTypeDescription()
    {
        return t("Add a Simple Slider to your Site");
    }

    public function getBlockTypeName()
    {
        return t("Simple Slider");
    }

    public function add()
    {
        $this->requireAsset('core/file-manager');
        $this->requireAsset('core/sitemap');
    }

    public function edit()
    {
        $this->requireAsset('core/file-manager'); 
        $this->requireAsset('core/sitemap');  
        
        $db = Loader::db();
        $items = $db->GetAll('SELECT * from btVividSimpleSlide WHERE bID = ? ORDER BY sort', array($this->bID));
        $this->set('items', $items);
    }

    public function view()
    {
        $db = Loader::db();
        $items = $db->GetAll('SELECT * from btVividSimpleSlide WHERE bID = ? ORDER BY sort', array($this->bID));
        $this->set('items', $items);
        
        $uh = Loader::helper('concrete/urls');
        $bObj = $this->getBlockObject();       
        $bt = $bObj->getBlockTypeObject();
        $blockURL = $uh->getBlockTypeAssetsURL($bt);
        $this->set("blockURL",$blockURL);
    }

    public function duplicate($newBID) {
        parent::duplicate($newBID);
        $db = Loader::db();
        $v = array($this->bID);
        $q = 'select * from btVividSimpleSlide where bID = ?';
        $r = $db->query($q, $v);
        while ($row = $r->FetchRow()) {
            $vals = array($newBID,$row['title'][$i],$row['slidedesc'][$i],$row['btnText'][$i],$row['fID'][$i],$row['pageID'][$i],$row['sort'][$i]);  
            $db->execute('INSERT INTO btVividSimpleSlide (bID, title, slidedesc, btnText, fID, pageID, sort) values(?,?,?,?,?,?,?)', $vals);
        }
    }

    public function delete()
    {
        $db = Loader::db();
        $db->delete('btVividSimpleSlide', array('bID' => $this->bID));
        parent::delete();
    }
    
    public function validate($args)
    {
        $e = Loader::helper('validation/error');
        if(empty($args['speed'])){
            $e->add(t("Speed must be set"));
        }
        if(!ctype_digit(trim($args['speed']))){
            $e->add(t("Speed must be solely numeric"));
        }
        if(empty($args['duration'])){
            $e->add(t("Duration must be set"));
        }
        if(!ctype_digit(trim($args['duration']))){
            $e->add(t("Duration must be solely numeric"));
        }
        if(empty($args['breakpoint1width'])){
            $e->add(t("The First \"Image Width\" must be set"));
        }
        if(!ctype_digit(trim($args['breakpoint1width']))){
            $e->add(t("The First \"Image Width\"  must be solely numeric"));
        }
          if(empty($args['breakpoint1height'])){
            $e->add(t("The First \"Image Height\"  must be set"));
        }
        if(!ctype_digit(trim($args['breakpoint1height']))){
            $e->add(t("The First \"Image Height\"  must be solely numeric"));
        }
        
        return $e;
    }

    public function save($args)
    {
        $db = Loader::db();
        $db->execute('DELETE from btVividSimpleSlide WHERE bID = ?', array($this->bID));
        $count = count($args['sort']);
        $i = 0;
        parent::save($args);
        while ($i < $count) {
            $vals = array($this->bID,$args['title'][$i],$args['slidedesc'][$i],$args['btnText'][$i],$args['fID'][$i],$args['pageID'][$i],$args['sort'][$i]);     
            $db->execute('INSERT INTO btVividSimpleSlide (bID, title, slidedesc, btnText, fID, pageID, sort) values(?,?,?,?,?,?,?)', $vals);
            $i++;
        }
       
        $blockObject = $this->getBlockObject();
        if (is_object($blockObject)) {
            $blockObject->setCustomTemplate($args['template']);
        }
    }
    

}