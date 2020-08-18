<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Категория ' . $category->name;
?>

<div class="col-md-8">

	<div class="content-head well">
        <h2>Поиск по категории "<?= $category->name ?>"</h2>
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