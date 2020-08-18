<?php

use yii\helpers\Html;

?>

<div class="admin-default-index">
    <ul>
        <li><h3><?= Html::a('Статьи', ['article/index']) ?></h3></li>
        <li><h3><?= Html::a('Категории', ['category/index']) ?></h3></li>
        <li><h3><?= Html::a('Теги', ['tag/index']) ?></h3></li>
    </ul>
</div>
