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
		*/
		// проверяем, что существует базовая директория компонентов вообще 
		$this->sureDirExists($this->component->basePath);		
		// проеряем	в /components/ директорию неймспейса
		$this->sureDirExists($this->component->MakeComponentNamespaceDirPath());		
		// директорию компонента
		$this->sureDirExists($this->component->MakeComponentDirPath());
	}

	function sureComponentFileExists(){
		$protitypeComponent = $this->getProtoCompPath().'.default/component.php';
		/**
		* @todo: искать прототип именно этого компонента в prototypes, и юзать стандартный только когда нет нужного 
		* и переопределять $protitypeComponent
		*/
		// если файл компонента уже существует, то и делать тут нечего
		if(file_exists($this->component->ComponentPath)) return true;
		if(
			file_exists($protitypeComponent)
		){
			$res = copy(
				$protitypeComponent, 
				$this->component->ComponentPath
				
			);
			chmod($this->component->ComponentPath,$this->fileMode);
		}
	}

	function sureComponentTemplateExists(){
		$this->sureComponentExists();
		// 
		// var_dump($this->component);
		/*
		вообще-то, исходя из рекурсивности sureDirExists, хватило бы и вызова на самый глубокий уровень 
		НО! тут же будут всякие поддержки шаблонов в /bitrix/ и /local/
		а также названия шаблонов сайтов и компонентов .default
		потому сразу делю на последовательные вызовы
		*/
		$targetTemplateDir = $this->component->MakeTemplateDirPath();
		// проверяем, что папка шаблонов существует
		if(!file_exists($targetTemplateDir)){
			$this->sureDirExists($targetTemplateDir);
			// иначе, копируем в новую директорию все содержимое прототипа
			$protitypeTemplateDir = $this->getProtoCompPath().'.default/templates/.default';
			/**
			* @todo: искать прототип именно этого компонента и шаблона в prototypes, и юзать стандартный только когда нет нужного 
			* переопределяя $protitypeComponent
			*/
			$this->copy_dir($protitypeTemplateDir, $targetTemplateDir);
		}
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
		if(!file_exists($path) || !is_dir($path)){
			return mkdir($path,$this->dirMode,true);
		}
		return true;
	}

	/**
	 * рекурсивное копирование директории 
	 * основано https://gist.github.com/davejamesmiller
	 * добавлена установка прав на файлы
	 */
	function copy_dir($src, $dst)
	{
		if (is_link($src)) {
	        symlink(readlink($src), $dst);
	    } elseif (is_dir($src)) {
	        mkdir($dst);
	        chmod($dst,$this->dirMode);
	        foreach (scandir($src) as $file) {
	            if ($file != '.' && $file != '..') {
	                $this->copy_dir("$src/$file", "$dst/$file");
	            }
	        }
	    } elseif (is_file($src)) {
	        error_reporting(E_ALL);
	        copy($src, $dst);
	        chmod($dst,$this->fileMode);
	    } else {
	        echo "WARNING: Cannot copy $src (unknown file type)\n";
	    }
	}
}