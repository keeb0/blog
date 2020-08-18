<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $article->title;
?>

<div class="col-md-8">
	<div class="site-update">
		<?php $form = ActiveForm::begin() ?>

			<?= $form->field($article, 'title'); ?>

			<?=
			$form->field($article, 'category_id')->dropDownlist($categoryNames, [
				'prompt' => 'Выберите категорию',
				'options' => [
					// '2' => ['selected' => true]
				]
			]); ?>
			<?= $form->field($article, 'image')->fileInput()->label('Новое фото'); ?>

			<?= $form->field($article, 'tags')->checkboxList($tagNames); ?>

			<?= $form->field($article, 'userTags'); ?>

			<?= $form->field($article, 'content')->textarea(); ?>

			<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
		<?php ActiveForm::end() ?>

		<hr>

	
	</div>
</div>

<?= $this->render('/templates/sidebar', [
    'categories' => $categories,
    'popularArticles' => $popularArticles,
]) ?>