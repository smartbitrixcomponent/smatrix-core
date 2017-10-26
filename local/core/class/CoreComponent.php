<?php
class Component {
    function __construct($componentName, $componentTemplate, $arParams = array(), $parentComponent = null, $arFunctionParams = array(), $template = 'site') {
        $this->basePath = __DIR__.'/../../components/';
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
    }


    public function getComponent() {
        if (file_exists($this->ComponentPath)) {
            require $this->ComponentPath;
        } else {
            echo "not found";
        }
    }
    private function MakeComponentPath($componentName) {
        return $this->basePath.$this->nameSpace."/".$this->folderName."/".$this->baseName;
    }
    private function MakeTemplatePath() {
        return $this->templatePath.$this->templateFilderName.$this->nameSpace."/".$this->folderName."/".$this->componentTemplateSubfilder.'/'.$this->templateBaseName;
    }
    private function getMockData() {
        return '';
    }

}
