<?php
require_once __DIR__."/CoreComponent.php";
class Core {
    const CSS_TEMPLATE = "<css />";
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
