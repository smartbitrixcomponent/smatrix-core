<?php
require_once __DIR__."/ComponentAdapter.php";
require_once __DIR__."/Config.php";
class Core {
    const CSS_TEMPLATE = "<__css__></__css__>";
    function __construct($template, $config = Config) {
        $this->template = $template;
        $this->basePath = __DIR__."/../../templates/".$this->template."/";
        $this->headerFile = "header.php";
        $this->footerFile = "footer.php";
        $this->JS = array();
        $this->CSS = array();
        $this->config = new $config();
    }
    public function IncludeComponent($componentName, $componentTemplate, $arParams = array(), $parentComponent = null, $arFunctionParams = array())
    {
        $component = new ComponentAdapter($componentName, $componentTemplate, $arParams, $parentComponent, $arFunctionParams, $this->template);
        $component->getComponent();
        if(!in_array($component->ComponentPathCSS, $this->CSS)) {
            array_push($this->CSS, $component->ComponentPathCSS);
        }
        if(!in_array($component->ComponentPathJS, $this->JS)) {
            array_push($this->JS, $component->ComponentPathJS);
        }
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
