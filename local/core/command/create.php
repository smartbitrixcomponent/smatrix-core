<?
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
$componentName = $argv[1];
$compTemplate = $argv[2];
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
$maker->sureComponentExists();
// $maker->sureComponentTemplateExists($component);