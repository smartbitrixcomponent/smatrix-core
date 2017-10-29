<?php
global $APPLICATION;
foreach($APPLICATION->JS as $script) {
    echo "<script src='$script'></script>";
}
$APPLICATION->includeFooter();
$html = ob_get_contents();
ob_end_clean();
echo $APPLICATION->combineHTML($html);
