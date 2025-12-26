<?php

namespace app\controllers;

use app\models\Article;
use app\models\Category;
use app\models\CommentForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 3600,
                'variations' => [
                    Yii::$app->request->get('per-page'),
                    Yii::$app->request->get('page'),
                ],
                'dependency' => [
                    'class' => 'yii\caching\DbDependency',
                    'sql' => Article::find()
                        ->select('COUNT(*)')
                        ->createCommand()
                        ->getRawSql(),
                ],
            ],
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['view'],
                'duration' => 3600,
                'variations' => [
                    Yii::$app->request->get('id'),
                ],
                'dependency' => [
                    'class' => 'yii\caching\DbDependency',
                    'sql' => Article::find()
                        ->select([
                            'title',
                            'description',
                            'content',
                            'image',
                        ])
                        ->where(['id' => Yii::$app->request->get('id')])
                        ->createCommand()
                        ->getRawSql(),
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
        $data = Article::getAll(1);
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
    
        return $this->render('index', [
            'articles' => $data['articles'],
            'pagination' => $data['pagination'],
            'popular' => $popular,
            'recent' => $recent,
            'categories' => $categories,
        ]);
    }
    
    public function actionView($id)
    {
        $article = Article::findOne($id);
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
        $comments = $article->verifiedComments;
        $commentForm = new CommentForm();

        $article->incrementViewCount();

        return $this->render('single', [
            'article' => $article,
            'popular' => $popular,
            'recent' => $recent,
            'categories' => $categories,
            'comments' => $comments,
            'commentForm' => $commentForm,
        ]);
    }
    
    public function actionCategory($id)
    {
        $data = Category::getArticlesByCategory($id);
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
        
        return $this->render('category', [
            'articles' => $data['articles'],
            'pagination' => $data['pagination'],
            'popular' => $popular,
            'recent' => $recent,
            'categories' => $categories,
        ]);
    }

    public function actionComment($id)
    {
        $commentForm = new CommentForm();

        if (
            $this->request->isPost &&
            $commentForm->load($this->request->post()) &&
            $commentForm->saveComment($id)
        ) {
            Yii::$app->session->setFlash('comment', Yii::t('app', 'Your comment will be added soon!'));

            return $this->redirect(['site/view',
                'id' => $id,
            ]);
        }
    }

}
