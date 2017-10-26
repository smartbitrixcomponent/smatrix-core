<?php
require_once __DIR__."/CoreComponent.php";
class Core {
    function __construct($template) {
        $this->template = $template;
        $this->basePath = __DIR__."/../../templates/".$this->template."/";
        $this->headerFile = "header.php";
        $this->footerFile = "footer.php";
    }
    public function IncludeComponent($componentName, $componentTemplate, $arParams = array(), $parentComponent = null, $arFunctionParams = array())
    {
        $component = new Component($componentName, $componentTemplate, $arParams, $parentComponent, $arFunctionParams, $this->template);
        $component->getComponent();
    }
    public function includeHeader() {
        require $this->basePath.$this->headerFile;
    }
    public function includeFooter() {
        require $this->basePath.$this->footerFile;
    }
}
