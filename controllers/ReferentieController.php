<?php

namespace app\controllers;

use app\models\LeerjaarVak;
use app\models\LeerjaarVakSearch;
use app\models\Log;
use app\models\LogSearch;
use app\models\Vak;
use app\models\VakSearch;
use yii\filters\AccessControl;
use Yii;
use yii\helpers\Html;
use yii\web\Response;
class ReferentieController extends \yii\web\Controller
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
    public function actionLeerjaarvak(){
        $searchModel = new LeerjaarVakSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $omschrijving = "Alle leerjaar met vakken bekeken";
        $target = "";
        $this->actionLog($omschrijving, $target);

        return $this->render('leerjaarvak', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionVak(){
        $searchModel = new VakSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $omschrijving = "Alle vakken bekeken";
        $target = "";
        $this->actionLog($omschrijving, $target);

        return $this->render('vak', [
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
    public function actionLeerjaarvakCreate()
    {
        $request = Yii::$app->request;
        $model = new LeerjaarVak();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'size'=> 'large',
                    'title'=> "Nieuw Leerjaarvak",
                    'content'=>$this->renderAjax('leerjaarvak_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){

                $omschrijving = "Nieuwe vak aan leerjaar  toegevoegd";
                $target = " ";
                $this->actionLog($omschrijving, $target);

                return [
                    'forceClose'=>true,
                    'forceReload'=>'#crud-datatable-pjax',
                ];
            }else{
                return [
                    'size'=> 'large',
                    'title'=> "Nieuw Leerjaarvak",
                    'content'=>$this->renderAjax('leerjaarvak_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }
    }
    public function actionLeerjaarvakUpdate($leerjaarvak_id)
    {
        $request = Yii::$app->request;
        $model = LeerjaarVak::findOne($leerjaarvak_id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'size'=> 'large',
                    'title'=> "Leerjaar vak bijwerken",
                    'content'=>$this->renderAjax('leerjaarvak_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){

                $omschrijving = "Leerjaar vak bijgewerkt";
                $target = $model->leerjaar_vak_id;
                $this->actionLog($omschrijving, $target);

                return [
                    'forceClose'=>true,
                    'forceReload'=>'#crud-datatable-pjax',
                ];
            }else{
                return [
                    'size'=> 'large',
                    'title'=> "Nieuw rechten groep",
                    'content'=>$this->renderAjax('leerjaarvak_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }
    }

    public function actionVakCreate()
    {
        $request = Yii::$app->request;
        $model = new Vak();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'size'=> 'large',
                    'title'=> "Nieuw Leerjaarvak",
                    'content'=>$this->renderAjax('vak_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){

                $omschrijving = "Nieuwe vak  toegevoegd";
                $target = " ";
                $this->actionLog($omschrijving, $target);

                return [
                    'forceClose'=>true,
                    'forceReload'=>'#crud-datatable-pjax',
                ];
            }else{
                return [
                    'size'=> 'large',
                    'title'=> "Nieuw vak",
                    'content'=>$this->renderAjax('vak_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }
    }
    public function actionVakUpdate($vak_id)
    {
        $request = Yii::$app->request;
        $model = Vak::findOne($vak_id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'size'=> 'large',
                    'title'=> " Vak bijwerken",
                    'content'=>$this->renderAjax('vak_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){

                $omschrijving = "Vak bijgewerkt";
                $target = $model->vak_id;
                $this->actionLog($omschrijving, $target);

                return [
                    'forceClose'=>true,
                    'forceReload'=>'#crud-datatable-pjax',
                ];
            }else{
                return [
                    'size'=> 'large',
                    'title'=> "Vak bijwerken",
                    'content'=>$this->renderAjax('vak_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }
    }
}
