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
        /**
         * @todo: guessComponentPath - поиск подходящего компонента, с учетом разных неймспейсов, шаблонов сайта, и выброс ошибки 
         * $error = 'Компонент '.$this->nameSpace.':'.$this->folderName.' не существует.';
         */
        $this->ComponentPath = $this->MakeComponentPath($componentName);
        $this->ComponentDirPath = $this->MakeComponentDirPath($componentName);
        $this->ComponentPathTemplate = $this->MakeTemplatePath();
        $this->ComponentPathCSS = $this->getComponentAsset($this->MakeCSSPath());
        $this->ComponentPathJS = $this->getComponentAsset($this->MakeJSPath());
        /**
        * todo: объект $this->__template, в который занести все, что глубже папки компонента
        */
        $this->arParams = $arParams;
        $this->arResult = null;
    }


    public function getComponent() {
        /**
         * этот метод должен толкьо получать класс объекта компонента, и дергать его execute()
         * а методы ниже должны быть перенесены в отдельный класс компонента, плюсбазовый класс компонента получит часть методов адаптера, которые есть сейчас
         */
        $this->combineCSS();
        $this->combineJS();
        $this->executeComponent();
    }

    function executeComponent(){
        $arResult = $this->loadResultData();
        // компонент имеет собственный component.php, инклуд шабллона должен быть в нем
        if (file_exists($this->ComponentPath)) {
            $arParams = &$this->arParams;
            $this->arResult = $arResult;
            $arParams = &$this->arParams;
            require $this->ComponentPath;
            return;
        }
        // дефолтное поведение - инклуд шаблона 
        $this->IncludeComponentTemplate();
    }

    function IncludeComponentTemplate(){
        if(file_exists($this->ComponentPathTemplate)) {
            $arResult = $this->arResult;
            $arParams = $this->arParams;
            /**
             * @todo: result_modifier
             */
            require $this->ComponentPathTemplate;
            /**
            * @todo: epilog ????????????
            */
        } else {
            echo "error: Template '".$this->componentTemplateSubfolder."' of component '".$this->nameSpace.':'.$this->folderName."' not found";
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
            $APPLICATION = Core::getInstance();
            /**
             * @todo: в методы APPLICATION
             */
            if(!in_array($this->ComponentPathCSS, $APPLICATION->CSS)) {
                array_push($APPLICATION->CSS, $this->ComponentPathCSS);
            }
            return $this->ComponentPathCSS;
        }
        return;
    }
    private function combineJS() {
        if(file_exists($this->ComponentPathJS)) {
            $APPLICATION = Core::getInstance();
            /**
             * @todo: в методы APPLICATION
             */
            if(!in_array($this->ComponentPathJS, $APPLICATION->JS)) {
                array_push($APPLICATION->JS, $this->ComponentPathJS);
            }
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

    private function loadResultData() {
        $data = array();
        $jsonPath = $this->MakeJSONPath();
        if(file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            $data = json_decode($json, true);
        }
        return $this->arResult = $data;
    }

}
