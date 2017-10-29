<?
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
$componentName = $argv[1];
$componentTemplate = $argv[2];
if(strpos($componentName, 'bitrix:') === 0){
	exit('components in bitrix: namespace are disallowed');
}
if(!$componentTemplate){
	$componentTemplate = '.default';
}
// $siteTemplate = $argv[3]; ??? надо ли... может и надо
if(!$siteTemplate){
	$siteTemplate = 'site';
}

if(!$componentName){
	exit('usage: create.php namespace:component [template=.default]'/*.' [siteTemplate]'*/) ;
}
/**
 * @todo: на автолоад
 */
require_once __DIR__."/../class/Core.php";
require_once __DIR__."/../class/ComponentMaker.php";

$APPLICATION = Core::getInstance();
$APPLICATION->setSiteTemplate($siteTemplate);

$maker = new ComponentMaker($componentName, $componentTemplate);
// $maker->sureComponentTemplateExists(); // включено в sureComponentTemplateExists
$maker->sureComponentTemplateExists();