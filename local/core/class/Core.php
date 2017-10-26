<?php
require_once __DIR__."/CoreComponent.php";
require_once __DIR__."/ComponentMaker.php";
class Core {
    const CSS_TEMPLATE = "<css />";
    function __construct($template = '.default') {
        $this->setSiteTemplate($template);
        $this->headerFile = "header.php";
        $this->footerFile = "footer.php";
        $this->JS = array();
        $this->CSS = array();
    }
    static public function getInstance(){
        global $APPLICATION;
        if(!($APPLICATION instanceof Core)){
            $APPLICATION = new Self;
        }
        return $APPLICATION;
    }

    public function setSiteTemplate($templateName){
        $this->template = $templateName;
        $this->basePath = __DIR__."/../../templates/".$this->template."/";
    }
    public function getSiteTemplate(){
        return $this->template;
    }

    public function IncludeComponent($componentName, $componentTemplate, $arParams = array(), $parentComponent = null, $arFunctionParams = array())
    {
        $component = new Component($componentName, $componentTemplate, $arParams, $parentComponent, $arFunctionParams);
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
    public function ShowCSS() {
        echo self::CSS_TEMPLATE;
    }
    public function combineHTML($html) {
        $cssHtml = $this->CSSInHtml();
        $html = $this->replaceCSS($html, $cssHtml);
        return $html;
    }
    public function CSSInHtml() {
        $html = '';
        foreach($this->CSS as $css) {
            if($css) {
                $html .= '<link rel="stylesheet" href="'.$css.'">';
            }
        }
        return $html;
    }
    public function replaceCSS($html, $css) {
        return str_replace(self::CSS_TEMPLATE, $css, $html);
    }

}
