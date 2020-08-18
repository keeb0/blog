<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use app\models\Article;
use app\models\Category;
use app\models\Tag;
use app\models\UploadedImage;
use app\models\forms\NewArticle;

class ArticleController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update'],
                'rules' => [
                    [
                        'actions' => ['create', 'update'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ]
            ]
        ];
    }

    public function actionIndex($id)
    {
        $article = $this->findModel($id);
        $popularArticles = Article::getPopular(4);
        $categories = Category::getAll();
        $article->riseViews();

        return $this->render('index', [
            'article' => $article,
            'popularArticles' => $popularArticles,
            'categories' => $categories,
        ]);
    }

    public function actionCreate()
    {
        $article = new Article();
        $popularArticles = Article::getPopular(4);
        $categoryNames = Category::getAllNames();
        $categories = Category::getAll();
        $tagNames = Tag::getAllNames();

        if ($article->load(Yii::$app->request->post()) && $article->validate()) {
            $this->setTags($article);
            $this->setImage($article);

            $articleId = $article->createArticle();

            return $this->redirect(['article/index', 'id' => $articleId]);
        }

        return $this->render('create', [
            'article' => $article,
            'tagNames' => $tagNames,
            'popularArticles' => $popularArticles,
            'categoryNames' => $categoryNames,
            'categories' => $categories,
        ]);
    }

    public function actionUpdate($id)
    {
        $article = $this->findModel($id);
        if ($article->author_id === Yii::$app->user->identity->id) {
            $popularArticles = Article::getPopular(4);
            $categoryNames = Category::getAllNames();
            $categories = Category::getAll();
            $tagNames = Tag::getAllNames();
            $oldImageName = $article->image;

            if (!empty(Yii::$app->request->post('image'))) {
                $this->setImage($article);
            }
            else {
                if ($article->load(Yii::$app->request->post()) && $article->validate()) {
                $this->setTags($article);
                $this->setImage($article, $oldImageName);

                $article->updateArticle();

                return $this->redirect(['article/index', 'id' => $article->id]);
            }
            }

            return $this->render('update', [
                'article' => $article,
                'tagNames' => $tagNames,
                'popularArticles' => $popularArticles,
                'categoryNames' => $categoryNames,
                'categories' => $categories,
            ]);
        }
        else
            return $this->goHome();
    }

    private function findModel($id)
    {
        return Article::findOne($id);
    }

    private function setImage($article, $oldImageName = null)
    {
        if ($file = UploadedFile::getInstance($article, 'image')) {
            $image = new UploadedImage($file);
            $article->image = $image->saveImage(Article::getImagesFolder());
        }
        else
            $article->image = $oldImageName;
    }

    private function setTags($article)
    {
        $article->userTags = Yii::$app->request->post('Article')['userTags'];
        $article->updatedTags = Yii::$app->request->post('Article')['tags'];
    }
}
