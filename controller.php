<?php      

namespace Concrete\Package\VividSimpleSlider;
use Package;
use BlockType;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package
{

    protected $pkgHandle = 'vivid_simple_slider';
    protected $appVersionRequired = '5.7.1';
    protected $pkgVersion = '1.0';
    
    
    
    public function getPackageDescription()
    {
        return t("Add a Simple Slider to your Site");
    }

    public function getPackageName()
    {
        return t("Simple Slider");
    }
    
    public function install()
    {
        $pkg = parent::install();
        BlockType::installBlockTypeFromPackage('vivid_simple_slider', $pkg); 
        
    }
}
?>