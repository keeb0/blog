<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<?php foreach ($articles as $article): ?>
    <article class="blog-post">
        <div class="blog-post-image">
            <a href="<?= Url::to(['article/index', 'id' => $article->id]) ?>">
                <img src="<?= $article->getImage() ?>" alt="">
            </a>
        </div>
        <div class="blog-post-body">
            <h2><a href="<?= Url::to(['article/index', 'id' => $article->id]) ?>"><?= $article->title ?></a></h2>
            <div class="post-meta">
                <span>Автор <a href="#"><?= $article->author->name ?></a></span>/
                <span><i class="fa fa-clock-o"></i><?= $article->getDate() ?></span>/
                <span><a href="<?= Url::to(['site/category', 'id' => $article->category->id]) ?>">
                    <?= $article->category->name ?>
                </a></span>
                
                <div class="tag-list">
                    <?php foreach ($article->tags as $tag): ?>
                        <a class="tag" href="<?= Url::to(['site/tag', 'id' => $tag->id]) ?>"><?= '#'.$tag->name ?> </a>
                    <?php endforeach ?>
                </div>
            </div>

            <p><?= substr($article->content, 0, 400) ?></p>
            <div class="read-more"><a href="<?= Url::to(['article/index', 'id' => $article->id]) ?>">Открыть статью</a></div>
        </div>

        <div class="views">
            <p class="fa fa-eye"> <?= $article->viewed ?></p>
        </div>
    </article>
<?php endforeach ?>

<?= LinkPager::widget(['pagination' => $pagination]) ?>