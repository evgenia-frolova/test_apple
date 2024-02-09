<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use backend\models\Apple;
use yii\db\Expression;

/**
 * Site controller
 */
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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'fall', 'eat'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Apple;
        
        if ($model->load(Yii::$app->request->post())){
            
            if ($model->color !== 'green' && $model->color !== 'red') {
                Yii::$app->session->setFlash('success', 'Поле цвет должно принимать значение green или red');
            }
            
            $model->created_at = new Expression('NOW()');
            $model->save();
        }
        
        $appleArray = Apple::find()->all();
        
        return $this->render('apple', [
            'model' => $model,
            'appleArray' => $appleArray,
        ]);
    }
    
    public function actionFall()
    {
        $idApple = (int)Yii::$app->getRequest()->getQueryParam('id');
        
        if (Apple::find()->where(['id' => $idApple])->one()->fall()){
            return $this->goBack(); 
        }
    }   
    
    public function actionEat()
    {
        if (!Yii::$app->request->post()) 
            return 'Произошла ошибка!';
            
            
        $idApple = (int)Yii::$app->request->post('id');
        $percent = (int)Yii::$app->request->post('balance');
        
        if ($message = Apple::find()->where(['id' => $idApple])->one()->eat($percent)) {
            Yii::$app->session->setFlash('success', $message);
            return $this->goBack(); 
        }
    } 

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
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
