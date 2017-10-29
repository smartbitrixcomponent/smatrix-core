<?php
    require __DIR__."/local/core/bootstrap/header.php"
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
    require __DIR__."/local/core/bootstrap/footer.php"
?>
