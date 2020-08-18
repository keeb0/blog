<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-8">
	<div class="site-signup">
	    <h1><?= Html::encode($this->title) ?></h1>

	    <?php $form = ActiveForm::begin() ?>

	        <?= $form->field($signupForm, 'name') ?>

	        <?= $form->field($signupForm, 'email') ?>

	        <?= $form->field($signupForm, 'password')->passwordInput() ?>

	        <?= Html::submitButton('Войти', ['class' => 'btn btn-success']) ?>

	    <?php ActiveForm::end() ?>
	</div>
</div>
