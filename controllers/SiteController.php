<?php

namespace app\controllers;

use app\models\Log;
use app\models\Users;
use RobThree\Auth\TwoFactorAuth;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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

    public function actionIndex()
    {

        return $this->redirect(['dashboard/startpagina']);
    }

    public function actionLog($omschrijving, $target){
        $model = new Log();
        $model->user_id = Yii::$app->user->id;
        $model->omschrijving = $omschrijving;
        $model->datum = date('Y-m-d H:i');
        $model->target_id = $target;
        $model->save();

    }
    public function actionLogin()
    {
        $authenticator = new TwoFactorAuth();
        $this->layout = "main-login";
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) ) {
            $username = $model->username;
            $auth = $model->auth_key;
            $key = Users::find()->where(['username'=> $username])->one()->auth_key;
            if ($authenticator->verifyCode($key, $model->auth_key)) {
                $model->login();
                $omschrijving = "$username successvol ingelogd";
                $target = "";
                $this->actionLog($omschrijving, $target);
                return $this->redirect(['index']);
            }
//            else {
//                $model->login();
//                $omschrijving = "$username successvol bypassed login";
//                $target = "";
//                $this->actionLog($omschrijving, $target);
//                return $this->redirect(['index']);
//            }
            $omschrijving = "$username foutief ingelogd";
            $target = "";
            $this->actionLog($omschrijving, $target);
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        $naam = Yii::$app->user->identity->fullname;
        $omschrijving = " $naam uitgelogd ";
        $target = "";
        $this->actionLog($omschrijving, $target);

        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

}
