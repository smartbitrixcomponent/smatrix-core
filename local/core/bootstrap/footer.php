<?php
foreach($APPLICATION->JS as $script) {
    echo "<script src='$script'></script>";
}
$APPLICATION->includeFooter();
