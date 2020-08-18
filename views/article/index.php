<?php

/* @var $this yii\web\View */

// use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $article->title;
?>

<div class="col-md-8">
    <article class="blog-post">

        <div class="content-head">
            <?php if (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->id == $article->author_id): ?>
                <?= Html::a('Редактирвоть статью', ['article/update' , 'id' => $article->id], ['class' => 'creating-submit']) ?>
            <?php endif ?>
        </div>
        
        <div class="blog-post-body">
            <h2><?= $article->title ?></h2>
            <div class="post-meta">
                <span>Автор <a href="#"><?= $article->author->name ?></a></span>/
                <span><i class="fa fa-clock-o"></i><?= $article->getDate() ?></span>/
                <span><a href="<?= Url::to(['site/category', 'id' => $article->category->id]) ?>"><?= $article->category->name ?></a></span>

                <div class="tag-list">
                    <?php foreach ($article->tags as $tag): ?>
                        <a class="tag" href="<?= Url::to(['site/tag', 'id' => $tag->id]) ?>"><?= '#'.$tag->name ?> </a>
                    <?php endforeach ?>
                </div>
            </div>
            
        <div class="blog-post-image">
            <img src="<?= $article->getImage() ?>" alt="">
        </div>
            
            <p><?= $article->content ?></p>

        </div>
    </article>
</div>
<?= $this->render('/templates/sidebar', [
    'categories' => $categories,
    'popularArticles' => $popularArticles,
]) ?>