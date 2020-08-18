<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Article;
use app\models\Category;
use app\models\Tag;
use app\models\forms\Login;
use app\models\forms\Signup;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $data = Article::getOnMain(5);
        $popularArticles = Article::getPopular(4);
        $categories = Category::getAll();

        return $this->render('index', [
            'articles' => $data['articles'],
            'pagination' => $data['pagination'],
            'popularArticles' => $popularArticles,
            'categories' => $categories,
        ]);
    }

    public function actionCategory($id)
    {
        $category = Category::findOne($id);
        $data = $category->getArticlesByCategory(5);
        $popularArticles = Article::getPopular(4);
        $categories = Category::getAll();

        return $this->render('category', [
            'category' => $category,
            'articles' => $data['articles'],
            'pagination' => $data['pagination'],
            'popularArticles' => $popularArticles,
            'categories' => $categories,
        ]);
    }

    public function actionTag($id)
    {
        $tag = Tag::findOne($id);
        $data = $tag->getArticlesByTag(5);
        $popularArticles = Article::getPopular(4);
        $categories = Category::getAll();

        return $this->render('tag', [
            'tag' => $tag,
            'articles' => $data['articles'],
            'pagination' => $data['pagination'],
            'popularArticles' => $popularArticles,
            'categories' => $categories,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginForm = new Login();
        if ($loginForm->load(Yii::$app->request->post()) && $loginForm->validate()) {
            Yii::$app->user->login($loginForm->getUser());

            return $this->goHome();
        }

        $loginForm->password = '';
        return $this->render('login', [
            'loginForm' => $loginForm,
        ]);
    }

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $signupForm = new Signup();
        if ($signupForm->load(Yii::$app->request->post()) && $signupForm->signup()) {
            return $this->goBack();
        }

        $signupForm->password = '';
        return $this->render('signup', [
            'signupForm' => $signupForm,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
