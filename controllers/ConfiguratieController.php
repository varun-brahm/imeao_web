<?php

namespace app\controllers;

use app\models\Log;
use app\models\LogSearch;
use app\models\Recht;
use app\models\RechtSearch;
use app\models\Users;
use app\models\UsersLog;
use app\models\UsersSearch;
use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\TwoFactorAuthException;
use yii\filters\AccessControl;
use Yii;
use yii\helpers\Html;
use yii\web\Response;
use BaconQrCode\Encoder\QrCode;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer as QrCodeWriter;

class ConfiguratieController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionLog($omschrijving, $target){
        $model = new Log();
        $model->user_id = Yii::$app->user->id;
        $model->omschrijving = $omschrijving;
        $model->datum = date('Y-m-d H:i');
        $model->target_id = $target;
        $model->save();

    }
    public function actionGebruiker()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $omschrijving = "Alle users bekeken";
        $target = "";
        $this->actionLog($omschrijving, $target);

        return $this->render('gebruiker', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLogView()
    {
        $searchModel = new LogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['log_id' => SORT_DESC];


        $omschrijving = " Log bekeken";
        $target = "";
        $this->actionLog($omschrijving, $target);

        return $this->render('log', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRecht(){
        $searchModel = new RechtSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $omschrijving = "Alle rechten bekeken";
        $target = "";
        $this->actionLog($omschrijving, $target);

        return $this->render('recht', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGebruikerView($id)
    {
        $request = Yii::$app->request;
        $model = Users::findOne($id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'size'=> 'large',
                    'title'=> "Bekijk Gebruiker",
                    'content'=>$this->renderAjax('gebruiker_view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"])

                ];
            }
        }
    }

    public function actionGebruikerCreate()
    {
        $request = Yii::$app->request;
        $model = new Users();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'size'=> 'large',
                    'title'=> "Nieuw Gebruiker aanmaken",
                    'content'=>$this->renderAjax('gebruiker_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post())){

                $omschrijving = "Nieuwe user aangemaakt $model->name";
                $target = $model->id;
                $this->actionLog($omschrijving, $target);

                $model->auth_key = (new TwoFactorAuth)->createSecret();
                $key = $model->auth_key;
                $model->save();

                return [
                    'size'=> 'large',
                    'title'=> "2FA",
                    'content'=>$this->renderAjax('code', [
                        'id' => $model->id,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"])
                ];

//                return [
//                    'forceClose'=>true,
//                    'forceReload'=>'#crud-datatable-pjax',
//                ];
            }else{
                return [
                    'size'=> 'large',
                    'title'=> "Nieuw Gebruiker test varun",
                    'content'=>$this->renderAjax('gebruiker_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }
    }


    public function actionRechtCreate()
    {
        $request = Yii::$app->request;
        $model = new Recht();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'size'=> 'large',
                    'title'=> "Nieuw rechten groep",
                    'content'=>$this->renderAjax('recht_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){

                $omschrijving = "Nieuwe rechten groep aangemaakt $model->naam";
                $target = $model->recht_id;
                $this->actionLog($omschrijving, $target);

                return [
                    'forceClose'=>true,
                    'forceReload'=>'#crud-datatable-pjax',
                ];
            }else{
                return [
                    'size'=> 'large',
                    'title'=> "Nieuw rechten groep",
                    'content'=>$this->renderAjax('recht_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }
    }


    public function actionRechtUpdate($recht_id)
    {
        $request = Yii::$app->request;
        $model = Recht::findOne($recht_id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'size'=> 'large',
                    'title'=> "Rechten groep bijwerken",
                    'content'=>$this->renderAjax('recht_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){

                $omschrijving = "Rechten groep $model->naam bewerkt";
                $target = $model->recht_id;
                $this->actionLog($omschrijving, $target);

                return [
                    'forceClose'=>true,
                    'forceReload'=>'#crud-datatable-pjax',
                ];
            }else{
                return [
                    'size'=> 'large',
                    'title'=> "Nieuw rechten groep",
                    'content'=>$this->renderAjax('recht_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }
    }

    /**
     * @throws TwoFactorAuthException
     */
    public function actionGebruikerUpdate($id)
    {
        $request = Yii::$app->request;
        $model = Users::findOne($id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'size'=> 'large',
                    'title'=> "Bewerk Gebruiker #".$id,
                    'content'=>$this->renderAjax('gebruiker_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post())){

                $omschrijving = "users $model->name bewerkt";
                $target = $model->id;
                $this->actionLog($omschrijving, $target);

                $model->auth_key = (new TwoFactorAuth)->createSecret();
                $key = $model->auth_key;
                 $model->save();
//                return $this->redirect(['show-code', 'id' => $model->id]);


                return [
                    'size'=> 'large',
                    'title'=> "2FA",
                    'content'=>$this->renderAjax('code', [
                        'id' => $model->id,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"])
                ];
            }else{
                return [
                    'size'=> 'large',
                    'title'=> "Bewerk Gebruiker #".$id,
                    'content'=>$this->renderAjax('gebruiker_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }


    public function actionGebruikerDelete($id)
    {
        $request = Yii::$app->request;
        $model = Users::findOne($id);
         $model->delete();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'forceClose'=>true,
                    'forceReload'=>'#crud-datatable-pjax',
                ];
        }
    }

    public function actionShowCode($id)
    {
        $model = Users::findOne($id);
        $model->auth_key = (new TwoFactorAuth)->createSecret();
        $model->save();

        $request = Yii::$app->request;


        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){


                $omschrijving = "Nieuwe Two Factor Autentication code aangemaakt voor $model->name";
                $target = $model->id;
                $this->actionLog($omschrijving, $target);

                return [
                    'size'=> 'large',
                    'title'=> "",
                    'content'=>$this->renderAjax('code', [
                        'id' => $id,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceClose'=>true,
                    'forceReload'=>'#crud-datatable-pjax',
                ];
            }else{
                return [
                    'size'=> 'large',
                    'title'=> "Bewerk Klas gegevens",
                    'content'=>$this->renderAjax('code', [
                        'id' => $id,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"])
                ];
            }
        }
    }
}
