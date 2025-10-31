<?php

namespace app\controllers;

use app\models\BoekSearch;
use app\models\Boek;
use app\models\Log;
use app\models\Schooljaar;
use app\models\SchooljaarSearch;
use app\models\Student;
use app\models\StudentSearch;
use yii\filters\AccessControl;
use Yii;
use yii\helpers\Html;
use yii\web\Response;

class StudentController extends \yii\web\Controller
{


    public function actionLog($omschrijving, $target){
        $model = new Log();
        $model->user_id = Yii::$app->user->id;
        $model->omschrijving = $omschrijving;
        $model->datum = date('Y-m-d H:i');
        $model->target_id = $target;
        $model->save();

    }
    public function actionStudent()
    {

        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $omschrijving = "Alle studenten bekeken";
        $target = "";
        $this->actionLog($omschrijving, $target);

        return $this->render('student', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionStudentAlgeheel()
    {
        $searchModel = new SchooljaarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $allColumns = [
            // Main table columns
            ['attribute' => 'schooljaar', 'label' => 'Schooljaar'],
            ['attribute' => 'huidige_klas', 'label' => 'Huidige Klas'],

            // Joined table columns
            ['attribute' => 'student.id_nummer', 'label' => 'ID Nummer'],
            ['attribute' => 'student.naam', 'label' => 'Naam'],
            ['attribute' => 'student.voornaam', 'label' => 'Voornaam'],
            ['attribute' => 'student.geslacht', 'label' => 'Geslacht'],
            ['attribute' => 'student.geboorte_datum', 'label' => 'Geboorte Datum'],
            ['attribute' => 'student.email_adres', 'label' => 'Email Adres'],
            // Add others as needed
        ];
        $selectedAttributes = Yii::$app->request->get('columns', array_column($allColumns, 'attribute'));

        // Filter columns array by selected attributes
        $selectedColumns = array_filter($allColumns, function ($col) use ($selectedAttributes) {
            return in_array($col['attribute'], $selectedAttributes);
        });

        $omschrijving = "Alle studenten bekeken";
        $target = "";
        $this->actionLog($omschrijving, $target);

        return $this->render('schooljaar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allColumns' => $allColumns,
            'selectedAttributes' => $selectedAttributes,
            'selectedColumns' => $selectedColumns,
        ]);
    }
    public function actionStudentUpdate($student_id)
    {
        $request = Yii::$app->request;
        $model = Student::findOne($student_id);
        $this->layout = 'main-empty';

        if ($request->isGet) {
            return $this->renderAjax('student_form', [
                'model' => $model,
                'size' => 'large',
                'title' => "Bewerk student #" . $student_id,
            ]);
        } else {
            if ($model->load($request->post()) && $model->save()) {
                $naam = Student::findOne($student_id)->naam;
                $voornaam = Student::findOne($student_id)->voornaam;
                $omschrijving = "Student $naam $voornaam gegevens bijgewerkt";
                $target = $student_id;
                $this->actionLog($omschrijving, $target);

                Yii::$app->session->setFlash('success', 'Data saved successfully.');
                return $this->redirect(['student-update', 'student_id' => $student_id]);

            } else {
                return $this->renderAjax('student_form', [
                    'model' => $model,
                    'size' => 'large',
                    'title' => "Bewerk boek #" . $student_id,
                ]);
            }
        }
    }

    public function actionStudentKlasUpdate($schooljaarid)
    {
        $request = Yii::$app->request;
        $model =  Schooljaar::findOne($schooljaarid);
        $student = Student::findOne($model->IDstudent);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'size'=> 'large',
                    'title'=> "Nieuwe Klas ",
                    'content'=>$this->renderAjax('student_klas_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post())){
                $model->IDstudent = $student->studentID;
                $model->stortingbewijs = -1;
                $model->save();
                $omschrijving = " klas bijgewerkt voor ".$student->naam." ".$student->voornaam;
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

    public function actionStudentKlasCreate($studentid)
    {
        $request = Yii::$app->request;
        $model = new Schooljaar();
        $student = Student::findOne($studentid);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'size'=> 'large',
                    'title'=> "Nieuwe Klas ",
                    'content'=>$this->renderAjax('student_klas_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post())){
                $model->IDstudent = $studentid;
                $model->stortingbewijs = -1;
                $model->save();
                $omschrijving = "Nieuwe klas toegevoed voor ".$student->naam." ".$student->voornaam;
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

    public function actionStudentCreate()
    {
        $request = Yii::$app->request;
        $model =  new Student;
        $this->layout = 'main-empty';

        if ($request->isGet) {
            return $this->renderAjax('student_form', [
                'model' => $model,
                'size' => 'large',
                'title' => "Bewerk student #" ,
            ]);
        } else {
            if ($model->load($request->post()) && $model->save()) {
                $naam = $model->naam;
                $voornaam = $model->voornaam;
                $omschrijving = "Student $naam $voornaam gegevens bijgewerkt";
                $target = $model->studentID;
                $this->actionLog($omschrijving, $target);

                Yii::$app->session->setFlash('success', 'Data saved successfully.');
                return $this->redirect(['student-update','student_id'=>$model->studentID]);

            } else {
                return $this->renderAjax('student_form', [
                    'model' => $model,
                    'size' => 'large',
                    'title' => "Bewerk boek #",
                ]);
            }
        }
    }
    public function actionStudentVerklaring($studentid){
        $request = Yii::$app->request;
        $model =  Student::findOne($studentid);
        $stud_info_desc = Schooljaar::find()
            ->where(['IDstudent' => $studentid])
            ->orderBy(['id' => SORT_DESC])
            ->one();
        $stud_info_asc = Schooljaar::find()
            ->where(['IDstudent' => $studentid])
            ->orderBy(['id' => SORT_ASC])
            ->one();
        $this->layout = 'main-empty';

        $naam = $model->naam;
        $voornaam = $model->voornaam;
        $omschrijving = "Student $naam $voornaam verklaring gemaakt";
        $target = $model->studentID;
        $this->actionLog($omschrijving, $target);

        if ($request->isGet) {
            return $this->renderAjax('verklaring', [
                'model' => $model,
                'stud_info_desc'=> $stud_info_desc,
                'stud_info_asc'=> $stud_info_asc,            ]);
        }
    }
    public function actionStudentVerklaring2($studentid){
        $request = Yii::$app->request;
        $model =  Student::findOne($studentid);
        $stud_info_desc = Schooljaar::find()
            ->where(['IDstudent' => $studentid])
            ->orderBy(['id' => SORT_DESC])
            ->one();
        $stud_info_asc = Schooljaar::find()
            ->where(['IDstudent' => $studentid])
            ->orderBy(['id' => SORT_ASC])
            ->one();
        $this->layout = 'main-empty';

        $naam = $model->naam;
        $voornaam = $model->voornaam;
        $omschrijving = "Student $naam $voornaam verklaring gemaakt";
        $target = $model->studentID;
        $this->actionLog($omschrijving, $target);

        if ($request->isGet) {
            return $this->renderAjax('verklaring2', [
                'model' => $model,
                'stud_info_desc'=> $stud_info_desc,
                'stud_info_asc'=> $stud_info_asc,            ]);
        }
    }
    public function actionStudentAfschrijving($studentid){
        $request = Yii::$app->request;
        $model =  Student::findOne($studentid);
        $stud_info_desc = Schooljaar::find()
            ->where(['IDstudent' => $studentid])
            ->orderBy(['id' => SORT_DESC])
            ->one();
        $stud_info_asc = Schooljaar::find()
            ->where(['IDstudent' => $studentid])
            ->orderBy(['id' => SORT_ASC])
            ->one();
        $this->layout = 'main-empty';

        $naam = $model->naam;
        $voornaam = $model->voornaam;
        $omschrijving = "Student $naam $voornaam afschrijving gemaakt";
        $target = $model->studentID;
        $this->actionLog($omschrijving, $target);

        if ($request->isGet) {
            return $this->renderAjax('afschrijving', [
                'model' => $model,
                'stud_info_desc'=> $stud_info_desc,
                'stud_info_asc'=> $stud_info_asc,

            ]);
        }
    }

    public function actionAlgeheelView($id)
    {
        $klas = Schooljaar::findOne($id);

        // Get all students in this class and schooljaar
        $studenten = Schooljaar::find()
            ->where([
                'huidige_klas' => $klas->huidige_klas,
                'schooljaar' => $klas->schooljaar
            ])
//            ->all()
        ;

        // Extract all student IDs
//        $studentIds = array_map(fn($s) => $s->IDstudent, $studenten);

//        $query = \app\models\Student::find()->where(['studentID' => $studentIds]);

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $studenten,
            'pagination' => false,
        ]);

        // When exporting (ExportMenu appends export=1 or export=pdf etc.)
        if (\Yii::$app->request->get('export')) {
            // Render ONLY the innermost table to avoid exporting layout
            return $this->renderPartial('student_algeheel_klas', [
                'id' => $id,
//                'ids' => $studentIds,
            ]);
        }

        // Normal view with nested files
        return $this->renderAjax('student_algeheel', [
            'klas' => $klas,
            'dataProvider' => $dataProvider,
            'id' => $id,
//            'ids' => $studentIds,
        ]);
    }

    public function actionStudentKlasDelete($schooljaarid)
    {
        $request = Yii::$app->request;
        $model =  Schooljaar::findOne($schooljaarid);
        $student = Student::findOne($model->IDstudent);

        $naam = $student->naam;
        $voornaam = $student->voornaam;
        $klas = $model->huidige_klas;
        $omschrijving = "Student $naam $voornaam afgeschreven uit $klas ";
        $target = $model->IDstudent;
        $this->actionLog($omschrijving, $target);

        $model->delete();
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'forceClose'=>true,
                'forceReload'=>'#crud-datatable-pjax',
            ];
        }

    }


}
