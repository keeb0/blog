<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Тег ' . $tag->name;
?>

<div class="col-md-8">

	<div class="content-head well">
        <h2>Статьи с тегом #<?= $tag->name ?></h2>
    </div>

    <?= $this->render('/templates/list-of-articles', [
        'articles' => $articles,
        'pagination' => $pagination,
    ]) ?>

</div>
<?= $this->render('/templates/sidebar', [
    'categories' => $categories,
    'popularArticles' => $popularArticles,
]) ?>