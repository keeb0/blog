<?php

use yii\helpers\Url;

?>
<div class="col-md-4 sidebar-gutter">
    <aside>
    <!-- sidebar-widget -->
    <div class="sidebar-widget">
        <h3 class="sidebar-title">Популярные посты</h3>
        <div class="widget-container">
            <?php foreach ($popularArticles as $article): ?>
                <article class="widget-post">
                <div class="post-image">
                    <a href="<?= Url::to(['article/index', 'id' => $article->id]) ?>">
                        <img src="<?= $article->getImageForSb() ?>" alt="">
                    </a>
                </div>
                <div class="post-body">
                    <h2><a href="<?= Url::to(['article/index', 'id' => $article->id]) ?>"><?= $article->title ?></a></h2>
                    <div class="post-meta">
                        <span>
                            <i class="fa fa-clock-o"></i><?= $article->getDate() ?>
                        </span>
                        <span>
                            <a href="<?= Url::to(['site/category', 'id' => $article->category->id]) ?>"><?= $article->category->name ?></a>
                        </span>
                    </div>
                </div>
            </article>
            <?php endforeach ?>
        </div>
    </div>
    <!-- sidebar-widget -->
   <!--  <div class="sidebar-widget">
        <h3 class="sidebar-title">Socials</h3>
        <div class="widget-container">
            <div class="widget-socials">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-google-plus"></i></a>
                <a href="#"><i class="fa fa-dribbble"></i></a>
                <a href="#"><i class="fa fa-reddit"></i></a>
            </div>
        </div>
    </div> -->
    <!-- sidebar-widget -->
    <div class="sidebar-widget">
        <h3 class="sidebar-title">Категории</h3>
        <div class="widget-container">
            <ul>
                <?php foreach ($categories as $key => $category): ?>
                    <li>
                        <a href="<?= Url::to(['site/category', 'id' => $category->id]) ?>">
                            <?= $category->name ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    </div>
    </aside>
</div>