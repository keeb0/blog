<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\PublicAsset;

PublicAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?= Url::to(['/']) ?>">Главная</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <li><a href="<?= Url::to(['/site/login']) ?>">Вход</a></li>

                    <?php else: ?>
                    <?php if (Yii::$app->user->identity->isAdmin): ?>
                        <li><a href="<?= Url::to(['/admin/default/index']) ?>">Админ панель</a></li>
                    <?php endif ?>
                        <li><a><?= \Yii::$app->user->identity->name ?></a></li>
                        <li><a href="<?= Url::to(['/site/logout']) ?>">Выход</a></li>
                    <?php endif ?>
                </ul>

            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">
        <section>
            <div class="row">
                <div class="content">
                    <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <?= Alert::widget() ?>

                    <?= $content ?>
                </div>
            </div>
        </section>
    </div><!-- /.container -->

    <footer class="footer">

        <div class="footer-socials">
        </div>

        <div class="footer-bottom">
            <i class="fa fa-copyright"></i> Copyright 2015. All rights reserved.<br>
            Theme made by <a href="http://www.moozthemes.com">MOOZ Themes</a>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
