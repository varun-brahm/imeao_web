<?php

namespace app\controllers;

use app\models\CijferKlas;
use app\models\Jaar;
use app\models\Klas;
use app\models\KlasSearch;
use app\models\KlasVakDocent;
use app\models\LeerjaarVak;
use app\models\Recht;
use app\models\School;
use app\models\Log;
use app\models\SchoolSearch;
use app\models\Student;
use app\models\StudentCijfer;
use app\models\StudentCijferSearch;
use app\models\User;
use app\models\Users;
use app\models\UsersType;
use app\models\Vak;
use kartik\mpdf\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\SqlDataProvider;
use RobThree\Auth\TwoFactorAuth;
use yii\web\UploadedFile;

/**
 * AdministratieController implements the CRUD actions for Link model.
 */
class AdministratieController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulkdelete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Link models.
     * @return mixed
     */
    public function actionLog($omschrijving, $target){
        $model = new Log();
        $model->user_id = Yii::$app->user->id;
        $model->omschrijving = $omschrijving;
        $model->datum = date('Y-m-d H:i');
        $model->target_id = $target;
        $model->save();

    }
    public function actionSchool()
    {
        $searchModel = new SchoolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $pers = Yii::$app->user;
        $persid = $pers->id;
        $pers_recht = Users::findOne($persid)->recht_id;
        $docent_naam = UsersType::find()->where(['name' => 'Leerkracht'])->one();
        $docentid = $docent_naam->id;
        $user_type = Yii::$app->user->identity->functie;
        $user_recht = Recht::find()->where(['recht_id'=>$pers_recht])->one();

        $omschrijving = "Alle klassen bekeken";
        $target = "";
        $this->actionLog($omschrijving, $target);
        $currentmonth = date('m');
        $currentyear = date('Y');

        if($currentmonth <= 10){
            $yearPrefix = $currentyear -1 .'-'. $currentyear;

        }else{
            $yearPrefix = $currentyear .'-'. ($currentyear +1);
        }
        $year = Jaar::find()->where(['naam'=>$yearPrefix])->one();

        if($user_recht->update_all == 0) {
            $dataProvider->query->select(['school.Klas', 'schooljaar_id','school.vak_id','school.leerjaar_id','school.klas_id'])
                ->where(['schooljaar_id' => $year->jaar_id])
                ->andWhere(['Vakdocent'=> $persid])
            ;
        }else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
        $dataProvider->setSort([
            'defaultOrder' => ['klas_id' => SORT_DESC]
        ]);

        return $this->render('school', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
//            'currentmonth' => $schooljaar,
        ]);
    }

    public function actionSchoolUpdate($schoolid)
    {
        $klas = School::findOne($schoolid)->Klas;
        $klas_vak = School::findOne($schoolid)->vak_id;
        $vak = Vak::findOne($klas_vak)->vak;
        $omschrijving = "Klas $klas met vak $vak cijfers bekeken";
        $target = $schoolid;
        $this->actionLog($omschrijving, $target);

        $this->layout = 'main-empty';
        // Load all student models for the given school ID
        $models = StudentCijfer::find()
            ->where(['klas_id' => $schoolid])
            ->orderBy(['naam' => SORT_ASC])
            ->all();
        if(!$models){
            $models = null;
        }

        // Check if the form is submitted
        if (Yii::$app->request->isPost) {

            $klas = School::findOne($schoolid)->Klas;
            $klas_vak = School::findOne($schoolid)->vak_id;
            $vak = Vak::findOne($klas_vak)->vak;
            $omschrijving = "Klas $klas met vak $vak cijfers bewerkt";
            $target = $schoolid;
            $this->actionLog($omschrijving, $target);

            $postData = Yii::$app->request->post('Studentcijfer'); // Get the form data

            $success = true;

            // Iterate through each model
            foreach ($models as $model) {
                $key = $model->student_id;

                // Check if there is data for this model in the POST request
                if (isset($postData[$key])) {
                    // Load the data into the model and attempt to save
                    if (!$model->load($postData[$key], '') || !$model->save()) {
                        $success = false;
                        Yii::error('Failed to save model with ID ' . $key . ': ' . print_r($model->errors, true));
                        break; // Exit the loop if any model fails to save
                    }
                }
            }
            // Check if all models were saved successfully
            if ($success) {
//                Yii::$app->session->setFlash('success', 'Data saved successfully.');
//                return $this->redirect(['index']); // Redirect to index page or any other page
            } else {
                Yii::$app->session->setFlash('error', 'Failed to save data.');
            }
        }

        // Render the form
        return $this->render('school_form_2', [
            'models' => $models,
        ]);
    }

    public function actionError(){
        $this->layout = 'main-empty';
        return $this->render('../site/error_custom');
    }

    public function actionKlasCreate(){
        {
            $request = Yii::$app->request;
            $model = new School();



            if($request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                if($request->isGet){

//                    return $this->render('klas_new_form', ['model' => $model,]);
                    return [
                        'size'=> 'large',
                        'title'=> "Nieuw School",
                        'content'=>$this->renderAjax('klas_new_form', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                            Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                    ];
                }else if($model->load($request->post()) ){
                    if($model->validate()){
                        $allvak = LeerjaarVak::find()->where(['leerjaar_id' => $model->leerjaar_id])->all();
                        $omschrijving = "Nieuwe klassen $model->Klas aangemaakt";
                        $target = "";
                        $this->actionLog($omschrijving, $target);

                        foreach ($allvak as $vak) {
                            $newModel = new School();
                            $newModel->Klas = $model->Klas;
                            $newModel->vak_id = $vak->vak_id;
                            $newModel->leerjaar_id = $model->leerjaar_id;
                            $newModel->schooljaar_id = $model->schooljaar_id;
                            $newModel->mentor = $model->mentor;
                            $newModel->save();
                        }
                        return [
                            'forceClose'=>true,
                            'forceReload'=>'#crud-datatable-pjax',
                        ];
                    }else{
                        return [
                            'size'=> 'large',
                            'title'=> "Nieuw school",
                            'content'=>$this->renderAjax('klas_new_form', [
                                'model' => $model,
                            ]),
                            'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                        ];
                    }

                }else{
                    return [
                        'size'=> 'large',
                        'title'=> "Nieuw school",
                        'content'=>$this->renderAjax('klas_new_form', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                            Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                    ];
                }
            }
        }
    }

    public function actionKlasUpdate($klasid)
    {
        $request = Yii::$app->request;
        $model = School::findOne($klasid);
        $old_model = School::findOne($klasid);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'size'=> 'large',
                    'title'=> "Bewerk Klas Gegevens",
                    'content'=>$this->renderAjax('school_create_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                $klassen = School::find()->where(['Klas'=>$old_model->Klas])->all();

                foreach($klassen as $klas){
                    $new_model = School::findOne($klas->klas_id);
                    $new_model->mentor = $model->mentor;
                    $new_model->Klas = $model->Klas;
                    $new_model->schooljaar_id = $model->schooljaar_id;
                    $new_model->leerjaar_id = $model->leerjaar_id;
                    $new_model->save();
                }
                $klas = $model->Klas;
                $vak = Vak::findOne($model->vak_id)->vak;
                $omschrijving = "Klas $klas met vak $vak klas gegevens bewerkt";
                $target = $klasid;
                $this->actionLog($omschrijving, $target);

                return [
                    'forceClose'=>true,
                    'forceReload'=>'#crud-datatable-pjax',
                ];
            }else{
                return [
                    'size'=> 'large',
                    'title'=> "Bewerk Klas gegevens",
                    'content'=>$this->renderAjax('school_create_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }

    public function actionStudentCreate($id)
    {
        $request = Yii::$app->request;
        $model = new Studentcijfer();
        $model->klas_id = $id;
        $klas = School::findOne($id)->Klas;
        $allklas = School::find()->where(['Klas' => $klas])->all();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'size' => 'large',
                    'title' => "Nieuw Student",
                    'content' => $this->renderAjax('student_create_form', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-secondary pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit", 'id' => 'saveButton'])
                ];
            } else if($model->load($request->post()) ) {
                foreach ($model['student'] as $art) {
                    if (!empty($art['naam']) && !empty($art['voornaam'])) {
                        if($art['klas'] == 0) {
                            foreach ($allklas as $klasObj) {
                                $klas_id = $klasObj->klas_id;

                                $existingStudent = StudentCijfer::find()
                                    ->where(['naam' => $art['naam']])
                                    ->andWhere(['voornaam' => $art['voornaam']])
                                    ->andWhere(['klas_id' => $klas_id])
                                    ->count();

                                if ($existingStudent == 0) {
                                    $nartikel = new StudentCijfer();
                                    $nartikel->klas_id = $klas_id;
                                    $nartikel->naam = $art['naam'];
                                    $nartikel->voornaam = $art['voornaam'];
                                    $nartikel->no = $art['no'];
                                    $nartikel->opmerking = $art['opmerking'];
                                    if (!$nartikel->save()) {
                                        // Validation failed
                                        var_dump($nartikel->getErrors());
                                    }

                                    $naam = $nartikel->naam;
                                    $voornaam = $nartikel->voornaam;
                                    $klas_vak = School::findOne($klas_id)->vak_id;
                                    $vak = Vak::findOne($klas_vak)->vak;
                                    $omschrijving = "Student $naam $voornaam toegevoegd aan klas $klas_id met vak $vak";
                                    $target = $klas_id;

                                    $this->actionLog($omschrijving, $target);
                                }
                            }
                        }else{
                            $existingStudent = StudentCijfer::find()
                                ->where(['naam' => $art['naam']])
                                ->andWhere(['voornaam' => $art['voornaam']])
                                ->andWhere(['klas_id' => $id])
                                ->count();

                            if ($existingStudent == 0) {
                                $nartikel = new StudentCijfer();
                                $nartikel->klas_id = $id;
                                $nartikel->naam = $art['naam'];
                                $nartikel->voornaam = $art['voornaam'];
                                $nartikel->opmerking = $art['opmerking'];
                                if (!$nartikel->save()) {
                                    // Validation failed
                                    var_dump($nartikel->getErrors());
                                }

                                $naam = $nartikel->naam;
                                $voornaam = $nartikel->voornaam;
                                $klas_vak = School::findOne($id)->vak_id;
                                $vak = Vak::findOne($klas_vak)->vak;
                                $omschrijving = "Student $naam $voornaam toegevoegd aan klas $id met vak $vak";
                                $target = $id;

                                $this->actionLog($omschrijving, $target);
                            }
                        }
                    }
                }
                return [
                    'forceClose'=>true,
                    'forceReload' => '#crud-datatable-pjax',
                ];
            }
        } else {
            return [
                'size' => 'large',
                'title' => "Nieuw student",
                'content' => $this->renderAjax('student_create_form', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-secondary pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    }


    public function actionStudentDelete($id){
            $request = Yii::$app->request;
            $model = StudentCijfer::findOne($id);
            $schoolid = $model->klas_id;
            $klas = School::findOne($schoolid)->Klas;
            $klas_vak  = School::findOne($schoolid)->vak_id;
            $vak = Vak::findOne($klas_vak)->vak;

            $naam = $model->naam;
            $voornaam = $model->voornaam;
            $omschrijving = "Student $naam $voornaam verwijderd uit klas $klas met vak $vak";
            $target = $schoolid;
            $this->actionLog($omschrijving, $target);
            $model->delete();

            return $this->redirect(['school-update', 'schoolid' => $schoolid]);
        }


        public function actionStudent(){
            $searchModel = new StudentCijferSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $omschrijving = "Alle studenten bekeken";
            $target = "";
            $this->actionLog($omschrijving, $target);

            $dataProvider->query->select([
                'MIN(student_id) AS student_id', // or MAX, depending on which value you want
                'MIN(school.klas_id) AS klas_id',
                'school.Klas AS klas',
                'MIN(no) AS no',
                'naam',
                'voornaam',
//                'MIN(m1t1) AS m1t1',
//                'MIN(m1t2) AS m1t2',
//                'MIN(m2t1) AS m2t1',
//                'MIN(m2t2) AS m2t2',
//                'MIN(m3t1) AS m3t1',
//                'MIN(m3t2) AS m3t2',
//                'MIN(m1h1) AS m1h1',
//                'MIN(m1h2) AS m1h2',
//                'MIN(m1h3) AS m1h3',
//                'MIN(m1h4) AS m1h4',
//                'MIN(m2h1) AS m2h1',
//                'MIN(m2h2) AS m2h2',
//                'MIN(m2h3) AS m2h3',
//                'MIN(m2h4) AS m2h4',
//                'MIN(m3h1) AS m3h1',
//                'MIN(m3h2) AS m3h2',
//                'MIN(m3h3) AS m3h3',
//                'MIN(m3h4) AS m3h4',
//                'MIN(gehaald) AS gehaald',
//                'MIN(opmerking) AS opmerking',
//                'MIN(voldoende) AS voldoende',
//                'MIN(her1) AS her1',
//                'MIN(her2) AS her2',
//                'MIN(her3) AS her3',
            ])
                ->innerJoin('school', 'studentcijfer.klas_id = school.klas_id')
                ->groupBy(['school.Klas', 'naam', 'voornaam']);


            return $this->render('student', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

    public function actionStudentAlgeheel(){
        $searchModel = new StudentCijferSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $omschrijving = "Alle studenten bekeken";
        $target = "";
        $this->actionLog($omschrijving, $target);

        $dataProvider->query
            ->select([
                'MIN(student_id) AS student_id',
                'MIN(school.klas_id) AS klas_id',
                'MIN(no) AS no',
                'naam',
                'voornaam',
            ])
            ->innerJoin('school', 'studentcijfer.klas_id = school.klas_id')
            ->groupBy(['naam', 'voornaam']);



        return $this->render('student_algeheel', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
//    public function actionStudentAlgeheelUpdate($student_id){
//        $searchModel = new StudentCijferSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $omschrijving = "Alle studenten bekeken";
//        $target = "";
//        $this->actionLog($omschrijving, $target);
//
//        $dataProvider->query
//            ->select([
//                'MIN(student_id) AS student_id',
//                'MIN(school.klas_id) AS klas_id',
//                'MIN(no) AS no',
//                'naam',
//                'voornaam',
//            ])
//            ->innerJoin('school', 'studentcijfer.klas_id = school.klas_id')
//            ->groupBy(['naam', 'voornaam']);
//
//
//
//        return $this->render('student_algeheel', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    public function actionStudentAlgeheelUpdate($studentid)
    {
        $this->layout = 'main-empty';

        // Find one example StudentCijfer to get student name info
        $student = StudentCijfer::findOne($studentid);
        if (!$student) {
            throw new \yii\web\NotFoundHttpException("Student not found.");
        }

        $naam = trim($student->naam);
        $voornaam = trim($student->voornaam);

        // Get all klassen for this student (adjust query to fetch klas_id & vak_id)
        $klassen = School::find()
            ->alias('b')
            ->distinct()
            ->select(['b.Klas'])
            ->innerJoin('studentcijfer a', 'b.klas_id = a.klas_id')
            ->where(['like', 'a.naam', $naam])
            ->andWhere(['like', 'a.voornaam', $voornaam])
            ->all();

        // Get existing cijfers for this student indexed by klas_id
        $cijfers = StudentCijfer::find()
            ->where(['naam' => $naam, 'voornaam' => $voornaam])
            ->all();

        $cijfersByKlas = [];
        foreach ($cijfers as $c) {
            $cijfersByKlas[$c->klas_id] = $c;
        }

        // Define which grade fields to edit
        $fields = [
            'm1t1', 'm1t2', 'm2t1', 'm2t2', 'm3t1', 'm3t2',
            'm1h1', 'm1h2', 'm1h3', 'm1h4',
            'm2h1', 'm2h2', 'm2h3', 'm2h4',
            'm3h1', 'm3h2', 'm3h3', 'm3h4',
            'her1', 'her2', 'her3'
        ];

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();

            if (isset($postData['StudentCijfer']) && is_array($postData['StudentCijfer'])) {
                foreach ($postData['StudentCijfer'] as $studentCijferId => $fieldsData) {
                    $model = StudentCijfer::findOne($studentCijferId);
                    if ($model) {
                        // Assign each posted field to the model
                        foreach ($fields as $field) {
                            if (isset($fieldsData[$field])) {
                                $model->$field = $fieldsData[$field];
                            }
                        }

                        if (!$model->save()) {
                            Yii::error("Failed saving StudentCijfer ID $studentCijferId: " . json_encode($model->errors));
                            Yii::$app->session->setFlash('error', "Kon cijfers niet opslaan voor record ID $studentCijferId");
                        }
                    } else {
                        Yii::error("StudentCijfer record not found: ID $studentCijferId");
                    }
                }

                Yii::$app->session->setFlash('success', 'Cijfers succesvol opgeslagen.');
//                return $this->redirect(['student-algeheel-update', 'studentid' => $studentid]);
            }
        }



        return $this->render('student_algeheel_update_form', [
            'student' => $student,
            'klassen' => $klassen,
            'cijfersByKlas' => $cijfersByKlas,
            'fields' => $fields,
            'studentid' => $studentid,
        ]);
    }

    public function actionStudentRapport($studentid)
    {
        $db = Yii::$app->db;
        $this->layout = 'main-empty';

            $student = StudentCijfer::findOne($studentid);
            $naam = $student->naam;
            $voornaam = $student->voornaam;
            $klas_id = $student->klas_id;
            $klas = School::findOne($klas_id)->Klas;

            $command = $db->createCommand("
            SELECT a.naam, a.voornaam, a.m1t1, a.m1t2,a.her1, a.m2t1, a.m2t2,a.her2, a.m3t1, a.m3t2,a.her3, b.klas, c.vak, b.leerjaar_id, d.naam as leerjaar, b.mentor, b.schooljaar_id
            FROM studentcijfer a
            INNER JOIN school b ON a.klas_id = b.klas_id
            INNER JOIN vak c ON b.vak_id = c.vak_id
            INNER JOIN leerjaar d ON b.leerjaar_id = d.leerjaar_id
            WHERE a.naam = :naam
            AND a.voornaam = :voornaam
            AND b.Klas = :klas
            ORDER BY c.vak ASC;
        ");


            $command->bindValues([
                ':naam' => $naam,
                ':voornaam' => $voornaam,
                ':klas' => $klas,
            ]);

            $results = $command->queryAll();

//            var_dump($results);
//            die();
            if (empty($results)) {
                echo "No data found for the student.";

            }
            $naam = StudentCijfer::findOne($studentid)->naam;
            $voornaam = StudentCijfer::findOne($studentid)->voornaam;
            $omschrijving = "Student $naam $voornaam rapport gegenereerd";
            $target = $studentid;
            $this->actionLog($omschrijving, $target);

            return $this->render('rapport_form', [
                'results' => $results,
            ]);
    }

    public function actionStudentUpdate($studentid){
        $this->layout = 'main-empty';

        $student = StudentCijfer::findOne($studentid);
        $naam = $student->naam;
        $voornaam = $student->voornaam;
        $klas_id = $student->klas_id;
        $klas = School::findOne($klas_id)->Klas;
        $allklas = School::find()->where(['Klas'=> $klas])->all();
        $cijfers = StudentCijfer::find()->where(['naam' => $naam,'voornaam'=>$voornaam , 'klas_id' => $klas_id])->all();

        if (Yii::$app->request->isPost) {
            // Get the posted data
            $postData = Yii::$app->request->post();
            Yii::$app->session->setFlash('success', 'GOT HERE1');

            if (isset($postData['cijfers'])) {
                Yii::$app->session->setFlash('success', 'GOT HERE2');
                foreach ($cijfers as $model) {
                    $key = $model->student_id;

                    // Check if there is data for this model in the POST request
                    if (isset($postData[$key])) {
                        // Load the data into the model
                        if (!$model->load($postData[$key], '')) {
                            $success = false;
                            Yii::error('Failed to load data into model with ID ' . $key);
                            break; // Exit the loop if data loading fails
                        }

                        // Attempt to save the model
                        if (!$model->save()) {
                            $success = false;
                            Yii::error('Failed to save model with ID ' . $key . ': ' . print_r($model->errors, true));
                            break; // Exit the loop if model saving fails
                        }
                        $naam = StudentCijfer::findOne($studentid)->naam;
                        $voornaam = StudentCijfer::findOne($studentid)->voornaam;
                        $omschrijving = "Student $naam $voornaam cijfers bewerkt";
                        $target = $studentid;
                        $this->actionLog($omschrijving, $target);
                    }
                }
            }
        }

        return $this->render('student_update_form', [
            'allklas' => $allklas,
            'student' => $student,
            'cijfers' => $cijfers,
            'klas_id' => $klas_id,
            'studentid' => $studentid,
        ]);
    }



    public function actionSaveGrades()
    {
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();
            foreach ($postData['Studentcijfer'] as $studentId => $grades) {
                $studentCijfer = StudentCijfer::findOne($studentId);

                if ($studentCijfer !== null) {
                    $studentCijfer->load($grades, '');
                    if (!$studentCijfer->validate() || !$studentCijfer->save()) {
                        Yii::error("Failed to save grades for student ID: $studentId");
                    }
                } else {
                    Yii::error("Student with ID: $studentId not found.");
                }
            }
       return $this->redirect(['student-update', 'studentid' => $studentId]);
            // Redirect or return response as needed
        } else {
            Yii::error('Invalid request. Must be a POST request.');
        }
    }

    public function actionMoederlijst()
    {
        $searchModel = new SchoolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query
            ->select([
                'Klas',
                'klas_id',
                'leerjaar_id',
                'schooljaar_id'
            ])
            ->groupBy(['Klas']);

        return $this->render('moederlijst', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMoederlijstView($klas_id)
    {
        $this->layout = 'main-empty';
        $klas = School::findOne($klas_id)->Klas;
        $allklas = School::find()->where(['Klas' => $klas])->all();
        $allCijfers = [];

        foreach ($allklas as $class) {
            $classId = $class->klas_id;
            $vakId = $class->vak_id;
            $cijfers = StudentCijfer::find()->where(['klas_id' => $classId])->all();
            foreach ($cijfers as $cijfer) {
                $cijfer->vak_id = $vakId; // Add vak ID to the cijfer object
                $allCijfers[] = $cijfer;   // Add the cijfer object to the array
            }
        }

        $klas = School::findOne($klas_id)->Klas;
        $omschrijving = "Moederlijst gegenereerd van klas $klas";
        $target = $klas_id;
        $this->actionLog($omschrijving, $target);

        return $this->render('moederlijst_view', [
            'allklas' => $allklas,
            'allCijfers' => $allCijfers,
            'klas_id' => $klas_id

        ]);
    }

    public function actionUpload()
    {
        // Set response format to JSON
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Check if blob data was sent via POST request
        if (Yii::$app->request->isPost && $blob = Yii::$app->request->post('blob')) {
            // Define the directory where you want to save the blob data
            $uploadDirectory = Yii::getAlias('@webroot/rapport/');

            // Ensure that the upload directory exists
            if (!file_exists($uploadDirectory)) {
                if (!mkdir($uploadDirectory, 0777, true)) {
                    // Failed to create the directory
                    return ['success' => false, 'error' => 'Failed to create upload directory.'];
                }
            }

            // Generate a unique filename for the blob data
            $filename = uniqid('blob_');

            // Define the destination path for saving the blob data
            $destination = $uploadDirectory . $filename;

            // Save the blob data to the server
            if (file_put_contents($destination, base64_decode($blob))) {
                // Return a success response
                return ['success' => true, 'filename' => $filename];
            } else {
                // Return an error response
                return ['success' => false, 'error' => 'Failed to save blob data on the server.'];
            }
        } else {
            // No blob data was sent via POST request
            Yii::$app->response->statusCode = 400; // Bad Request
            return ['success' => false, 'error' => 'No blob data received.'];
        }
    }

//    public function actionExcelImport($id){
//        $spreadsheet = IOFactory::load($model->excelFile->tempName);
//    }

    public function actionExcelImport($id)
    {
//        ini_set('memory_limit', '512M');
        $request = Yii::$app->request;
        $model = new StudentCijfer();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'size'=> 'large',
                    'title'=> "Nieuw file uploaden",
                    'content'=>$this->renderAjax('excel_import', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post())){
                $model->file = UploadedFile::getInstance($model, 'file');
//                var_dump($model->file);

//                $omschrijving = "Nieuwe user aangemaakt $model->name";
//                $target = $model->id;
//                $this->actionLog($omschrijving, $target);
                $spreadsheet = IOFactory::load($model->file->tempName);
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray();
                $lastColumn = $sheet->getHighestColumn();
                $lastRow = $sheet->getHighestRow();

// Fetch all rows including headers
                $rows = $sheet->rangeToArray('A1:' . $lastColumn . $lastRow, null, true, true, true);

// Use row 2 as the field mapping
                $headers = $rows[2];

// Loop from row 3 onward (actual data)
                foreach ($rows as $rowIndex => $row) {
                    if ($rowIndex < 3) continue; // Skip first two rows

                    // Skip empty rows (optional)
                    if (empty($row['A']) && empty($row['B'])) continue;

                    // Find student
                    $student = StudentCijfer::find()->where([
                        'naam' => $row['A'] ?? null,
                        'voornaam' => $row['B'] ?? null,
                        'klas_id' => $id,
                    ])->one();

                    if ($student) {
                        foreach ($headers as $columnLetter => $fieldName) {
                            if (!empty($fieldName) && $student->hasAttribute($fieldName)) {
                                $student->$fieldName = $row[$columnLetter] ?? null;
                            }
                        }

                        if (!$student->save(false)) {
                            echo "❌ Error in row $rowIndex:<br>";
                            var_dump($student->getErrors());
                        }
                    }
                }
                return [
                    'forceClose'=>true,
                    'forceReload'=>'#crud-datatable-pjax',
                ];
//
            }else{
                return [
                    'size'=> 'large',
                    'title'=> "Nieuw Gebruiker test",
                    'content'=>$this->renderAjax('gebruiker_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }
    }

//    public function actionExcelUpload()
//    {
//        // Increase time and memory limits
//        ini_set('memory_limit', '512M');
//        ini_set('max_execution_time', '300');
//
//        $request = Yii::$app->request;
//        $model = new StudentCijfer();
//
////        if ($request->isAjax) {
////            Yii::$app->response->format = Response::FORMAT_JSON;
//
//            if ($request->isGet) {
//                // Modal for uploading the file
////                return [
////                    'size' => 'large',
////                    'title' => "Nieuw file uploaden(UNDER DEVELOPMENT)",
////                    'content' => $this->renderAjax('excel_import', [
////                        'model' => $model,
////                    ]),
////                    'footer' => Html::button('Close', [
////                            'class' => 'btn btn-secondary pull-left',
////                            'data-dismiss' => "modal"
////                        ]) .
////                        Html::button('Save', [
////                            'class' => 'btn btn-primary',
////                            'type' => "submit"
////                        ])
////                ];
//                return $this->render('excel_import', [
//                        'model' => $model,
//                ]);
//            }
//
//            if ($model->load($request->post())) {
//                $model->file = UploadedFile::getInstance($model, 'file');
//
//                if (!$model->file) {
//                    Yii::$app->session->setFlash('error', 'No file uploaded.');
//                    return $this->redirect(['index']);
//                }
//
//                // Mapping: Excel column headers => DB fields
//                $columnMap = [
//                    'HER M1' => 'her1',
//                    'M1T1'   => 'm1t1',
//                    'NAME'   => 'name',
//                    'EMAIL'  => 'email',
//                    // add other mappings here
//                ];
//
//                // Load Excel file (streamed)
//                $spreadsheet = IOFactory::load($model->file->tempName);
//
//                // Loop through sheets
//                foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
//                    $sheetName = $worksheet->getTitle();
//
////                    $metaInfo = [];  // store data from rows 3-4
////                    $header = [];    // will hold header row (row 6)
////                    $rowIndex = 0;
//
////                    foreach ($worksheet->getRowIterator() as $row) {
////                        $rowIndex++;
////
////                        // --- Process rows 3 & 4 (columns F:Z) ---
////                        if ($rowIndex == 3 || $rowIndex == 4) {
////                            foreach (range('F', 'Z') as $colLetter) {
////                                $value = $worksheet->getCell($colLetter . $rowIndex)->getValue();
////                                if (!empty($value)) {
////                                    $metaInfo["{$rowIndex}{$colLetter}"] = $value;
////                                }
////                            }
////                            continue;
////                        }
////
////                        // --- Row 6: column headers ---
////                        if ($rowIndex == 6) {
////                            foreach ($row->getCellIterator() as $cell) {
////                                $col = $cell->getColumn();
////                                $value = strtoupper(trim((string)$cell->getValue()));
////                                $header[$col] = $value;
////                            }
////                            continue;
////                        }
////
////                        // --- Skip rows before row 7 ---
////                        if ($rowIndex < 7) {
////                            continue;
////                        }
////
////                        // --- Data rows (from row 7 onwards) ---
////                        $record = new StudentCijfer();
////                        $record->sheet_name = $sheetName; // store sheet name
////
////                        // First handle priority columns C, D, then A, B
////                        foreach (['C', 'D', 'A', 'B'] as $priorityCol) {
////                            if (!isset($header[$priorityCol])) continue;
////                            $headerName = $header[$priorityCol];
////                            if (isset($columnMap[$headerName])) {
////                                $value = $worksheet->getCell($priorityCol . $rowIndex)->getValue();
////                                $record->{$columnMap[$headerName]} = $value;
////                            }
////                        }
////
////                        // Then handle the rest of the columns
////                        $cellIterator = $row->getCellIterator();
////                        $cellIterator->setIterateOnlyExistingCells(false);
////                        foreach ($cellIterator as $cell) {
////                            $col = $cell->getColumn();
////                            if (in_array($col, ['A', 'B', 'C', 'D'])) continue; // skip priority cols
////                            $headerName = $header[$col] ?? null;
////                            if ($headerName && isset($columnMap[$headerName])) {
////                                $record->{$columnMap[$headerName]} = $cell->getValue();
////                            }
////                        }
////
////                        // Save the record without validation for speed
////                        $record->save(false);
////                    }
//                }
//
//                return $this->redirect(['error']);
////                return [
////                    'forceClose' => true,
////                    'forceReload' => '#crud-datatable-pjax',
////                ];
//            } else {
//                // If form load failed
//                return [
//                    'size' => 'large',
//                    'title' => "Nieuw Gebruiker test",
//                    'content' => $this->renderAjax('gebruiker_form', [
//                        'model' => $model,
//                    ]),
//                    'footer' => Html::button('Close', [
//                            'class' => 'btn btn-secondary pull-left',
//                            'data-dismiss' => "modal"
//                        ]) .
//                        Html::button('Save', [
//                            'class' => 'btn btn-primary',
//                            'type' => "submit"
//                        ])
//                ];
//            }
//        }
//    }

    public function actionExcelUpload()
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');

        $request = Yii::$app->request;
        $model = new StudentCijfer();

        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'size'=> 'large',
                'title'=> "Nieuw file uploaden",
                'content'=>$this->renderAjax('excel_import', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                    Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

            ];
        }

        if ($model->load($request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if (!$model->file) {
                Yii::$app->session->setFlash('error', 'No file uploaded.');
                return $this->redirect(['index']);
            }

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($model->file->tempName);


            $sheetNames = [];
            $metaData = [];

            foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
                $sheetName = $worksheet->getTitle();
                $sheetHighestColumn = $worksheet->getHighestColumn();
                $highestRow = $worksheet->getHighestRow();
                $headerRow = 6;
                $dataStartRow = 7;

                if (strncmp($sheetName, "Her", strlen("Her")) == 0) {
                    continue; // skip this sheet
                }

                $sheetNames[] = $sheetName;

                $rowNumber = 4;
                $columns = range('F', 'M');
                foreach ($columns as $col) {
                    $cellValue = $worksheet->getCell($col . $rowNumber)->getValue();
                    if (!empty($cellValue)) {
                        $vak = Vak::find()
                            ->where(['like', 'vak', $cellValue])
                            ->one();
                        if($vak) {
                            $school = School::find()
                                ->where(['schooljaar_id' => $model->no])
                                ->andWhere(['like', 'Klas', $sheetName])
                                ->andWhere(['like', 'vak_id', $vak->vak_id])
                                ->one();
                            if ($school) {
                                $colToAttribute = [];

                                foreach ($worksheet->getColumnIterator('E', $sheetHighestColumn) as $col) {
                                    $colLetter = $col->getColumnIndex();
                                    $headerValue = (string)$worksheet->getCell($colLetter . $headerRow)->getValue();

                                    $attribute = $this->mapHeaderToAttribute($headerValue);
                                    if ($attribute !== null) {
                                        $colToAttribute[$colLetter] = $attribute;
                                    }
                                }
//                            var_dump($colToAttribute);


                                for ($row = $dataStartRow; $row <= $highestRow; $row++) {
                                    // Columns C and D: Naam and Voornaam
                                    $naam = trim((string)$worksheet->getCell('C' . $row)->getValue());
                                    $voornaam = trim((string)$worksheet->getCell('D' . $row)->getValue());

                                    // Skip empty rows
                                    if ($naam === '' && $voornaam === '') {
                                        continue;
                                    }

                                    // Build row data from E onward
                                    $rowData = [];
                                    foreach ($colToAttribute as $colLetter => $attribute) {
                                        $cellValue = $worksheet->getCell($colLetter . $row)->getValue();
                                        $rowData[$attribute] = $cellValue;
                                    }

                                    // Try to find existing StudentCijfer record
                                    $studentCijfer = StudentCijfer::find()
                                        ->where([
                                            'naam' => $naam,
                                            'voornaam' => $voornaam,
                                            'klas_id' => $school->klas_id,
                                        ])
                                        ->one();

                                    if (!$studentCijfer) {
                                        // Student not found, skip this row
//                                        var_dump($naam);
//                                        var_dump($school->klas_id);
//
//                                        die();
                                        continue;  // moves to next iteration of your row loop
                                    }

                                    // Load the mapped data into model
                                    foreach ($rowData as $attr => $value) {
//                                    var_dump($rowData);
//                                    die();
                                        if ($studentCijfer->hasAttribute($attr)) {
                                            $studentCijfer->$attr = $value;
                                        }
                                    }
                                    $studentCijfer->save(false);

                                    // Save (no validation for speed; change to true if you want validation)
//                                if (!$studentCijfer->save(false)) {
//                                    Yii::warning("Failed to save for {$naam} {$voornaam} on row {$row}");
//                                }else{
//
//                                }
                                }

                            }
                        }else{var_dump($cellValue);}


//                        $metaData[$sheetName][$col . $rowNumber] = $cellValue;
                    }
                }
            }

            // Build HTML output
            $output = '<h3>Sheet names:</h3><ul><li>' . implode('</li><li>', $sheetNames) . '</li></ul>';

            $output .= '<h3>Data from row 4 (columns F to M):</h3>';
            foreach ($metaData as $sheet => $cells) {
                $output .= "<h4>Sheet: " . htmlspecialchars($sheet) . "</h4><ul>";
                foreach ($cells as $cell => $value) {
                    $output .= "<li>" . htmlspecialchars($cell) . ": " . htmlspecialchars($value) . "</li>";
                }
                $output .= "</ul>";
            }

            return $this->renderContent($output);
        }

        return $this->render('excel_import', [
            'model' => $model,
        ]);
    }


//    public function actionUploadRaw($klas_id)
//    {
//        $model = new StudentCijfer(); // form model with 'rawData'
//        $request = Yii::$app->request;
//        Yii::$app->response->format = Response::FORMAT_JSON;
//
//
//        if ($model->load(Yii::$app->request->post())) {
//            $raw = trim($model->rawData);
//
//            $lines = preg_split('/\r\n|\r|\n/', $raw);
//
//            if (count($lines) < 2) {
//                Yii::$app->session->setFlash('error', 'Geen geldige data.');
//                return $this->redirect(['upload-raw']);
//            }
//
//            // First line = headers
//            $headers = explode("\t", array_shift($lines));
//
//            // Build column map dynamically (skip first 2 columns: Naam, Voornaam)
//            $colToAttribute = [];
//            foreach ($headers as $index => $headerValue) {
//                $headerValue = trim($headerValue);
//
//                // Skip columns 0 and 1 (Naam, Voornaam)
//                if ($index < 2) {
//                    continue;
//                }
//
//                // Use your helper to map the header to DB attribute
//                $attribute = $this->mapHeaderToAttribute($headerValue);
//                if ($attribute !== null) {
//                    $colToAttribute[$index] = $attribute;
//                }
//            }
//
//            $updated = 0;
//            $skipped = 0;
//
//            foreach ($lines as $line) {
//                if (trim($line) === '') {
//                    continue;
//                }
//
//                $cols = explode("\t", $line);
//                if (count($cols) < 2) {
//                    continue;
//                }
//
//                $naam = trim($cols[0]);
//                $voornaam = trim($cols[1]);
//
//                $student = StudentCijfer::find()
//                    ->where([
//                        'naam' => $naam,
//                        'voornaam' => $voornaam,
//                         'klas_id' => $klas_id
//                    ])
//                    ->one();
//
//                if (!$student) {
//                    $skipped++;
//                    continue;
//                }
//
//                // Assign values for each mapped column
//                foreach ($colToAttribute as $index => $attribute) {
//                    $value = isset($cols[$index]) ? trim($cols[$index]) : null;
//                    $student->$attribute = $value;
//                }
//
//                $student->save(false);
//                $updated++;
//            }
//
//            Yii::$app->session->setFlash(
//                'success',
//                "Verwerkt. $updated studenten bijgewerkt, $skipped overgeslagen."
//            );
//
//            return [
//                'forceClose'=>true,
//                'forceReload'=>'#crud-datatable-pjax',
//            ];
//        }
//
//
//        if($request->isGet){
//            return [
//                'size'=> 'large',
//                'title'=> "Nieuw file uploaden",
//                'content'=>$this->renderAjax('upload_raw', [
//                    'model' => $model,
//                ]),
//                'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
//                    Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
//
//            ];
//        }
//    }

    public function actionUploadRaw($klas_id)
        {
            $request = Yii::$app->request;
            $model = new StudentCijfer();

            if($request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                if($request->isGet){

                    return [
                        'size'=> 'large',
                        'title'=> "Paste",
                        'content'=>$this->renderAjax('upload_raw', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                            Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                    ];
                }else if($model->load($request->post()) ){
                    $raw = trim($model->rawData);

                    $lines = preg_split('/\r\n|\r|\n/', $raw);

                    if (count($lines) < 2) {
                        Yii::$app->session->setFlash('error', 'Geen geldige data.');
                        return [
                            'size'=> 'large',
                            'title'=> "Paste",
                            'content'=>$this->renderAjax('upload_raw', [
                                'model' => $model,
                            ]),
                            'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                        ];
                    }

                    // First line = headers
                    $headers = explode("\t", array_shift($lines));

                    // Build column map dynamically (skip first 2 columns: Naam, Voornaam)
                    $colToAttribute = [];
                    foreach ($headers as $index => $headerValue) {
                        $headerValue = trim($headerValue);

                        // Skip columns 0 and 1 (Naam, Voornaam)
                        if ($index < 2) {
                            continue;
                        }

                        // Use your helper to map the header to DB attribute
                        $attribute = $this->mapHeaderToAttribute($headerValue);
                        if ($attribute !== null) {
                            $colToAttribute[$index] = $attribute;
                        }
                    }

                    $updated = 0;
                    $skipped = 0;

                    foreach ($lines as $line) {
                        if (trim($line) === '') {
                            continue;
                        }

                        $cols = explode("\t", $line);
                        if (count($cols) < 2) {
                            continue;
                        }

                        $naam = trim($cols[0]);
                        $voornaam = trim($cols[1]);

                        $student = StudentCijfer::find()
                            ->where([
                                'naam' => $naam,
                                'voornaam' => $voornaam,
                                'klas_id' => $klas_id
                            ])
                            ->one();

                        if (!$student) {
                            $skipped++;
                            continue;
                        }

                        // Assign values for each mapped column
                        foreach ($colToAttribute as $index => $attribute) {
                            $value = isset($cols[$index]) ? trim($cols[$index]) : null;
                            $student->$attribute = $value;
                        }

                        $student->save(false);
                        $updated++;
                    }

                    Yii::$app->session->setFlash(
                        'success',
                        "Verwerkt. $updated studenten bijgewerkt, $skipped overgeslagen."
                    );

                    return [
                        'forceClose'=>true,
                        'forceReload'=>'#crud-datatable-pjax',
                    ];
                }else{
                    return [
                        'size'=> 'large',
                        'title'=> "Paste",
                        'content'=>$this->renderAjax('upload_raw', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                            Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                    ];
                }
            }
        }

    public function actionEditNaam($student_id)
    {
        $request = Yii::$app->request;
        $model =  StudentCijfer::findOne($student_id);
        $old_model =  StudentCijfer::findOne($student_id);


        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){

                return [
                    'size'=> 'large',
                    'title'=> "Paste",
                    'content'=>$this->renderAjax('edit_naam', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) ){

                $student_naam_overal = StudentCijfer::find()->where(['naam'=> $old_model->naam , 'voornaam'=>$old_model->voornaam])->all();
                foreach ($student_naam_overal as $student){
                    $nstudent = StudentCijfer::findOne($student->student_id);
                    $nstudent->naam = $model->naam;
                    $nstudent->voornaam = $model->voornaam;
                    if(!$nstudent->save()){
                        var_dump($nstudent);
                        die();
                    }
//                    $nstudent->save();
                }
                return [
                    'forceClose'=>true,
                    'forceReload'=>'#crud-datatable-pjax',
                ];
            }else{
                return [
                    'size'=> 'large',
                    'title'=> "Paste",
                    'content'=>$this->renderAjax('edit_naam', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }
    }

//    private function mapHeaderToAttribute(string $headerText, array $columnMap): ?string
//    {
//        // Normalize header
//        $headerText = strtoupper(trim($headerText));
//
//        // Step 1: Manual overrides
//        $manualMap = [
//            'HER M1'         => 'her1',
//            'HERKANSING M1'  => 'her1',
//            'EMAIL ADDRESS'  => 'email',
//            'STUDENT NAME'   => 'name',
//            // Add more manual mappings here
//        ];
//
//        if (isset($manualMap[$headerText])) {
//            return $manualMap[$headerText];
//        }
//
//        // Step 2: Exact match in columnMap
//        if (isset($columnMap[$headerText])) {
//            return $columnMap[$headerText];
//        }
//
//        // Step 3: Fuzzy match (levenshtein)
//        $closestKey = null;
//        $shortest = PHP_INT_MAX;
//        foreach ($columnMap as $key => $attr) {
//            $dist = levenshtein($headerText, strtoupper($key));
//            if ($dist < $shortest) {
//                $shortest = $dist;
//                $closestKey = $key;
//            }
//        }
//
//        // Apply a threshold for fuzzy matching
//        if ($shortest <= 2) { // allow up to 2 edits difference
//            return $columnMap[$closestKey];
//        }
//
//        // Step 4: Nothing found
//        return null;
//    }

    protected function mapHeaderToAttribute($headerValue)
    {
        // Step 1: Normalized header
        $normalized = strtoupper(trim($headerValue));

        // Step 2: Mapping table (Excel header → DB attribute)
        $mapping = [
            // Direct matches
            'OPMERKING' => 'opmerking',
            'NAAM' => 'naam',
            'VOORNAAM' => 'voornaam',

            // Excel "N0." likely corresponds to your 'no' field
            'N0.' => 'no',
            'NO' => 'no',

            // M1 / M2 / M3 tests
            'M1T1' => 'm1t1',
            'M1T2' => 'm1t2',
            'M2T1' => 'm2t1',
            'M2T2' => 'm2t2',
            'M3T1' => 'm3t1',
            'M3T2' => 'm3t2',

            // HER exams: normalize "HER M1" to her1, etc.
            'HER M1' => 'her1',
            'HER M2' => 'her2',
            'HER M3' => 'her3',

            // Some Excel exports may have "HER1" instead of "HER M1"
            'HERM1' => 'her1',
            'HERM2' => 'her2',
            'HERM3' => 'her3',
        ];


        // Direct mapping
        if (isset($mapping[$normalized])) {
            return $mapping[$normalized];
        }

        // Step 4: Nothing found
        return null;
    }

    public function actionPrintAlleRapport($klas_id)
    {
//        ini_set('max_execution_time', 300); // 5 minutes max execution
//        ini_set('memory_limit', '512M');
        $this->layout = 'main-empty';

        $students = StudentCijfer::find()->where(['klas_id' => $klas_id])->all();

        if (empty($students)) {
            throw new \yii\web\NotFoundHttpException("No students found for this class.");
        }

        $combinedHtml = '';
        $pageBreakHtml = '<div style="page-break-before: always;"></div>'; // fallback page break in HTML/CSS

        $combinedHtml = <<<HTML
        <style>
        @media print {
            .btn {
                display: none !important;
            }
        }
        </style>
    HTML;


        $combinedHtml .= <<<HTML
        <div style="margin-top: 20px;">
            <button onclick="window.print()" class="btn btn-info">Print</button>
        </div>
    HTML;

        foreach ($students as $index => $student) {
            $naam = $student->naam;
            $voornaam = $student->voornaam;
            $klas = School::findOne($student->klas_id)->Klas;

            $db = Yii::$app->db;
            $command = $db->createCommand("
                        SELECT a.naam, a.voornaam, a.m1t1, a.m1t2, a.her1, a.m2t1, a.m2t2, a.her2, a.m3t1, a.m3t2, a.her3,
                               b.klas, c.vak, b.leerjaar_id, d.naam AS leerjaar, b.mentor, b.schooljaar_id
                        FROM studentcijfer a
                        INNER JOIN school b ON a.klas_id = b.klas_id
                        INNER JOIN vak c ON b.vak_id = c.vak_id
                        INNER JOIN leerjaar d ON b.leerjaar_id = d.leerjaar_id
                        WHERE a.naam = :naam
                          AND a.voornaam = :voornaam
                          AND b.klas = :klas
                        ORDER BY c.vak ASC;

            ");
            $command->bindValues([
                ':naam' => $naam,
                ':voornaam' => $voornaam,
                ':klas' => $klas,
            ]);
            $results = $command->queryAll();

            // Render partial view for each student without layout
            $html = $this->renderPartial('rapport_form', ['results' => $results]);

            // Append student report and add a page break except after last one
            $combinedHtml .= $html;
                $combinedHtml .= $pageBreakHtml;
        }

//        $cssFile = Yii::getAlias('@webroot/css/rapport.css');
//
//        $pdf = new Pdf([
//            'mode' => Pdf::MODE_UTF8,
//            'format' => Pdf::FORMAT_A4,
//            'orientation' => Pdf::ORIENT_PORTRAIT,
//            'destination' => Pdf::DEST_BROWSER,
//            'content' => $combinedHtml,
////            'cssFile' => $cssFile,
//            'methods' => [
//                'SetTitle' => 'Alle Studenten Rapporten',
//                'SetAuthor' => 'Jouw Naam of School',
//            ], 
//        ]);

        $combinedHtml .= <<<HTML
        <div style="margin-top: 20px;">
            <button onclick="window.print()" class="btn btn-info">Print</button>
        </div>
    HTML;

        return $this->renderContent($combinedHtml);
    }
}
