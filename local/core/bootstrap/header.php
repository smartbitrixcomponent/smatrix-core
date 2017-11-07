<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
require_once __DIR__."/../class/Core.php";
/**
 *  Mock for Bitrix prolog code
 */
global $APPLICATION;
$APPLICATION = Core::getInstance();
$APPLICATION->setSiteTemplate('site');
ob_start();
$APPLICATION->includeHeader();

define("SITE_TEMPLATE_PATH", $APPLICATION->getSiteTemplatePath());
