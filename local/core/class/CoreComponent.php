<?php
class Component {
    function __construct($componentName, $componentTemplate, $arParams = array(), $parentComponent = null, $arFunctionParams = array(), $template = 'site') {
        $this->basePath = __DIR__.'/../../components/';
        $this->baseHTMLPath = '/local/templates/';
        $this->templatePath = __DIR__.'/../../templates/';
        $this->baseName = 'component.php';
        $this->templateBaseName = 'template.php';
        $this->componentTemplateSubfilder = $componentTemplate;
        $this->templateMockBaseName = 'arResult.json';
        $this->templateFilderName = $template.'/components/';
        $this->nameSpace = '';
        $this->folderName = '';
        $explodeName = explode(":", $componentName);
        $this->nameSpace = $explodeName[0];
        $this->folderName = $explodeName[1];
        $this->ComponentPath = $this->MakeComponentPath($componentName);
        $this->ComponentPathTemplate = $this->MakeTemplatePath();
        $this->ComponentPathCSS = $this->MakeCSSPath();
        $this->ComponentPathJS = $this->MakeJSPath();

    }


    public function getComponent() {
        if (file_exists($this->ComponentPath)) {
            require $this->ComponentPath;
            $this->combineCSS();
            $this->combineJS();
        } else {
            echo "not found";
        }
    }
    /**
     * TODO
     * Дописать mock
     */
    public function addExternalCss($path) {

    }
    /**
     * TODO
     * Дописать mock
     */
    public function addExternalJS($path) {

    }

    private function combineCSS() {
        if(file_exists($this->ComponentPathCSS)) {
            return $this->ComponentPathCSS;
        }
        return;
    }
    private function combineJS() {
        if(file_exists($this->ComponentPathJS)) {
            return $this->ComponentPathJS;
        }
        return;
    }


    private function MakeComponentPath($componentName) {
        return $this->basePath.$this->nameSpace."/".$this->folderName."/".$this->baseName;
    }
    private function MakeTemplatePath() {
        return $this->templatePath.$this->templateFilderName.$this->nameSpace."/".$this->folderName."/".$this->componentTemplateSubfilder.'/'.$this->templateBaseName;
    }
    private function MakeCSSPath() {
        return $this->baseHTMLPath.$this->templateFilderName.$this->nameSpace."/".$this->folderName."/".$this->componentTemplateSubfilder.'/style.css';
    }
    private function MakeJSPath() {
        return $this->baseHTMLPath.$this->templateFilderName.$this->nameSpace."/".$this->folderName."/".$this->componentTemplateSubfilder.'/script.js';
    }
    /**
     * TODO
     * Добавить заглушку для получения данных из json
     */
    private function getMockData() {
        return '';
    }


}
