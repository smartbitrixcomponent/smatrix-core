<?php
require_once __DIR__."/CoreComponent.php";
class Core {
    function __construct($template) {
        $this->template = $template;
        $this->basePath = __DIR__."/../../templates/".$this->template."/";
        $this->headerFile = "header.php";
        $this->footerFile = "footer.php";
        $this->JS = array();
        $this->CSS = array();
    }
    public function IncludeComponent($componentName, $componentTemplate, $arParams = array(), $parentComponent = null, $arFunctionParams = array())
    {
        $component = new Component($componentName, $componentTemplate, $arParams, $parentComponent, $arFunctionParams, $this->template);
        $component->getComponent();
        array_push($this->CSS, $component->ComponentPathCSS);
        array_push($this->JS, $component->ComponentPathJS);
    }
    public function includeHeader() {
        require $this->basePath.$this->headerFile;
    }
    public function includeFooter() {
        require $this->basePath.$this->footerFile;
    }
}
