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
<?php
    require __DIR__."/local/core/bootstrap/footer.php"
?>
