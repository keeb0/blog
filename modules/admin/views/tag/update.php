<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tag */

$this->title = 'Редактирование тега: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Админ панель', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Теги', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
