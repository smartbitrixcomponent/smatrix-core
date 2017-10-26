<?php

require_once __DIR__."/ComponentMaker.php";
class ComponentMaker {

	function __construct($componentName, $componentTemplate, $arParams = array(), $parentComponent = null, $arFunctionParams = array()) {
        $this->component = new ComponentAdapter($componentName, $componentTemplate);
        // считаем, что она есть. Создалась при установке пакета
        $this->protoDirPath = realpath(__DIR__.'/../prototype/');
        $this->protoComponentsDirPath = $this->protoDirPath;
        /*
    	TODO: из битриксовых конфигов, если они есть
    	или константы из композера прокидывать
    	*/
    	$this->dirMode = 0755;    
    	$this->fileMode = 0644;    
    }

	function sureComponentExists(){
		/*
		вообще-то, исходя из рекурсивности sureDirExists, хватило бы и вызова на самый глубокий уровень 
		НО! тут же будут всякие поддержки компонентов в /bitrix/ и /local/
		а также названия шаблонов сайтов и компонентов .default
		потому сразу делю на последовательные вызовы
		$this->protoDirPath
		*/
		// проверяем, что существует базовая директория компонентов вообще 
		$this->sureDirExists($this->component->basePath);		
		// проеряем	в /components/ директорию неймспейса
		$this->sureDirExists($this->component->MakeComponentNamespaceDirPath());		
		// директорию компонента
		$this->sureDirExists($this->component->MakeComponentDirPath());
		// сам файл компонента
		$this->sureComponentFileExists();
	}

	function sureComponentFileExists(){
		/**
		* @todo: искать прототип именно этого компонента в prototypes, и юзать стандартный только когда нет нужного
		*/
		// если файл компонента уже существует, то и делать тут нечего
		if(file_exists($this->component->ComponentPath)) return true;
		$res = copy(
			$this->getProtoCompPath().'.default/component.php', 
			$this->component->ComponentPath
			
		);
		chmod($this->component->ComponentPath,$this->fileMode);
	}

	///////////////////////////
	// методы получения адресов 
	///////////////////////////
	public function getProtoPath() {
		// считаем, что она есть. Создалась при установке пакета
        return realpath(__DIR__.'/../prototype').'/';
    }

    public function getProtoCompPath() {
		// считаем, что она есть. Создалась при установке пакета
        return realpath($this->getProtoPath().'/components').'/';
    }


	///////////////////////////
	// ниже пойдут улилиты
	///////////////////////////


	function sureDirExists($path){
		var_dump('sureDirExists '.$path);
		if(!file_exists($path) || !is_dir($path)){
			return mkdir($path,$this->dirMode,true);
		}
		return true;
	}
}
