<?php
require_once __DIR__."/../class/Core.php";
/**
 *  Mock for Bitrix prolog code
 */
global $APPLICATION;
$APPLICATION = new Core('site');
$APPLICATION->includeHeader();
