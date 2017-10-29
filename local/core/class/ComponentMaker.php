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
		// $this->sureDirExists($this->component->MakeComponentDirPath());
		$targetComponentDir = $this->component->MakeComponentDirPath();
		// проверяем, что папка компонента существует
		if(file_exists($targetComponentDir)){
			echo "component folder already exists\n";
			return;
		}
		$this->sureDirExists($targetTemplateDir);
		// иначе, копируем в новую директорию все содержимое прототипа
		$prototypeComponentDir = $this->getProtoCompPath().'.default/';
		// пытаемся найти прототип компонента по названию, если не удается - тогда .default
		foreach([$this->component->folderName,'.default'] as $prototypeComponentName){
			if(
				file_exists(($_prototypeComponentDir = $this->getProtoCompPath().$prototypeComponentName))
			){
				$prototypeComponentDir = $_prototypeComponentDir;
				break;	
			}
		}
		/**
		 * подумать, как быть с комплексными. 
		 */
		$this->copy_dir($prototypeComponentDir, $targetComponentDir,false);
	}

	public function sureComponentTemplateExists(){
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
		// var_dump('$targetTemplateDir '.$targetTemplateDir);
		// проверяем, что папка шаблонов существует
		if(file_exists($targetTemplateDir)){
			echo "template folder already exists\n";
			return;
		}
		$this->sureDirExists($targetTemplateDir);
		// иначе, копируем в новую директорию все содержимое прототипа
		$prototypeTemplateDir = $this->getProtoCompPath().'.default/templates/.default';
		// ищем компонент именно с таким названием, если получится
		foreach([$this->component->folderName,'.default'] as $prototypeComponentName){
			// если существует прототип такого компонента
			if(file_exists($this->getProtoCompPath().$this->component->folderName)){
				// тогда проверяем, существует ли .default или одноименный шаблон
				foreach([$this->component->componentTemplateSubfolder,'.default'] as $prototypeTemplateName){
					if(
						file_exists(($_prototypeTemplateDir = $this->getProtoCompPath().$prototypeComponentName.'/'.$prototypeTemplateName))
					){
						$prototypeTemplateDir = $_prototypeTemplateDir;
						break 2;	
					}
				}
			}
		}
		$this->copy_dir($prototypeTemplateDir, $targetTemplateDir);
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
	 * копирование директории 
	 * основано https://gist.github.com/davejamesmiller
	 * добавлена установка прав на файлы
	 * добавлен параметр, позволяющий рекурсию. Директория и первый уровень ее содержимого копируются всегда
	 * 
	 */
	function copy_dir($src, $dst,$recursive=true)
	{
		if (is_link($src)) {
	        symlink(readlink($src), $dst);
	    } elseif (is_dir($src)) {
	        mkdir($dst);
	        chmod($dst,$this->dirMode);
	        foreach (scandir($src) as $file) {
	            if ($file != '.' && $file != '..') {
	            	if(is_file("$src/$file") || $recursive){
	                	$this->copy_dir("$src/$file", "$dst/$file",$recursive);
	            	}
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