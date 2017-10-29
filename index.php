<?php
    require_once "local/helpers/frontend.php";
    __initHeader();
?>
<?php
    $APPLICATION->IncludeComponent("bitrix:simple", "default", array(
            "USE_PERSONALIZATION" => "Y",
            "SHOW_HIDDEN" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "86400"
        ),
        false
    );
?>
<?$APPLICATION->IncludeComponent("bitrix:button", "default", array("CONTENT" => "im button"));?>
<?$APPLICATION->IncludeComponent("bitrix:news", ".default");?>
<?$APPLICATION->IncludeComponent("bitrix:news", "template");?>
<?php
    __initFooter();
?>
