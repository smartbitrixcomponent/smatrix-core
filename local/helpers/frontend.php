<?php
require_once __DIR__."/../core/class/Config.php";
global $config;
$config = new Config();
function __initHeader() {
    global $config;
    if($config->getValue('ENV') === 'TEST') {
        require __DIR__."/../core/bootstrap/header.php";
    } else {
        require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    }

}

function __initFooter() {
    global $config;
    if($config->getValue('ENV') === 'TEST') {
        require __DIR__."/../core/bootstrap/footer.php";
    } else {
        require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
    }
}
