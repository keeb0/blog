<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Главная';
?>

<div class="col-md-8">

    <div class="content-head">
    	<?php if (!\Yii::$app->user->isGuest): ?>
    		<?= Html::a('Опубликовать статью', ['article/create'], ['class' => 'creating-submit']) ?>
    	<?php endif ?>
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