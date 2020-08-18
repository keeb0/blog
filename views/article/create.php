<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// \Yii::$app->clientScript->registerCoreScript('jquery.ui');
$this->title = 'Публикация статьи';
$this->registerJsFile('/ckeditor/ckeditor.js');
// $this->registerJsFile('/js/site/create-script.js');
// $this->registerJsFile('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js');
?>

<div class="col-md-8">
	<div class="site-create">
		<?php $form = ActiveForm::begin() ?>

			<?= $form->field($article, 'title'); ?>

			<?= $form->field($article, 'image')->fileInput(); ?>

			<?= 
			$form->field($article, 'category_id')->dropDownlist($categoryNames, [
				'prompt' => 'Выберите категорию',
				'options' => [
					// '2' => ['selected' => true]
				]
			]); ?>

			<?= $form->field($article, 'tags')->checkboxList($tagNames); ?>

			<?= $form->field($article, 'userTags'); ?>

			<?= $form->field($article, 'content')->textarea(); ?>

			<?= Html::submitButton('Опубликовать', ['class' => 'btn btn-success']) ?>
		<?php ActiveForm::end() ?>
	</div>
</div>

<?= $this->render('/templates/sidebar', [
    'categories' => $categories,
    'popularArticles' => $popularArticles,
]) ?>