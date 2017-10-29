<?php
class ComponentAdapter {
    function __construct($componentName, $componentTemplate, $arParams = array(), $parentComponent = null, $arFunctionParams = array()) {
        $APPLICATION = Core::getInstance();
        $this->basePath = __DIR__.'/../../components/';
        $this->templatePath = __DIR__.'/../../templates/';
        $this->baseHTMLPath = '/local/templates/';
        $this->baseName = 'component.php';
        $this->templateBaseName = 'template.php';
        /**
        * todo: поддержка .default шаблона 
        */
        $this->componentTemplateSubfolder = $componentTemplate;
        $this->templateMockBaseName = 'arResult.json';
        /**
        * todo: поддержка .default шаблона сайта 
        */
        $this->templateFolderName = $APPLICATION->getSiteTemplate().'/components/';
        $this->nameSpace = '';
        $this->folderName = '';
        $explodeName = explode(":", $componentName);
        $this->nameSpace = $explodeName[0];
        $this->folderName = $explodeName[1];
        $this->ComponentPath = $this->MakeComponentPath($componentName);
        $this->ComponentDirPath = $this->MakeComponentDirPath($componentName);
        $this->MockComponentPath = __DIR__."/../mock/component.php";
        $this->ComponentPathTemplate = $this->MakeTemplatePath();
        $this->ComponentPathCSS = $this->getComponentAsset($this->MakeCSSPath());
        $this->ComponentPathJS = $this->getComponentAsset($this->MakeJSPath());
        /**
        * todo: объект $this->__template, в который занести все, что глубже папки компонента
        */
        $this->arParams = $arParams;
    }


    public function getComponent() {
        /**
        * TODO: компонент должен быть объектом класса, и потенциально может не иметь файла component.php
        * тогда он наследуется от базового, и при инклуде выполняется метод Execute родителя
        * но то в битриксе, мы себе упрощаем пока что жизнь, и кладем component.php в каждую директорию компонента 
        * UPD: MockComponentPath - это шаг в сторону описанного
        */
        $arResult = $this->getMockData();
        $arParams = $this->arParams;
        $this->combineCSS();
        $this->combineJS();
        if (file_exists($this->ComponentPath)) {
            require $this->ComponentPath;
        } else {
            require $this->MockComponentPath;
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
    /**
    * @todo: разгрести этот хаос почти одинаковых названий, одни из которых относительно корня сайта, другие абсолютные, а третьи отностиельно core
    * привести все к путям относительно одной точки, а абсолютными адреса делать толкьо при работу с ФС
    */
    public function MakeComponentPath($componentName) {
        return $this->MakeComponentDirPath().$this->baseName;
    }
    public function MakeComponentDirPath() {
        return $this->MakeComponentNamespaceDirPath().$this->folderName."/";
    }
    public function MakeComponentNamespaceDirPath() {
        return $this->basePath.$this->nameSpace."/";
    }
    public function MakeTemplateDirPath() {
        return $this->templatePath.$this->templateFolderName.$this->nameSpace."/".$this->folderName."/".$this->componentTemplateSubfolder.'/';
    }
    public function MakeTemplatePath() {
        return $this->MakeTemplateDirPath().$this->templateBaseName;
    }
    public function MakeTemplateHTMLDirPath() {
        return $this->baseHTMLPath.$this->templateFolderName.$this->nameSpace."/".$this->folderName."/".$this->componentTemplateSubfolder.'/';
    }
    private function MakeCSSPath() {
        return $this->MakeTemplateHTMLDirPath().'style.css';
    }
    private function MakeJSPath() {
        return $this->MakeTemplateHTMLDirPath().'script.js';
    }
    private function MakeJSONPath() {
        return $this->MakeTemplateDirPath().'arResult.json';
    }
    private function getComponentAsset($path) {
        if(file_exists(__DIR__."/../../..".$path)) {
            return $path;
        } else {
            return;
        }
    }

    /**
     * TODO
     * Добавить заглушку для получения данных из json
     */
    private function getMockData() {
        $jsonPath = $this->MakeJSONPath();
        if(file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            return json_decode($json, true);
        }
        return array();
    }

}
