<ul>
<?php foreach($arResult['ITEMS'] as $item):?>
    <li>
        <?=$item['TITLE'];?>
        <div><?=$item['DESCRIPTION'];?></div>
    </li>
<?php endforeach;?>
</ul>
