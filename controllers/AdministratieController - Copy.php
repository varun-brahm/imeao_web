<?php

namespace app\controllers;

use app\models\CijferKlas;
use app\models\Jaar;
use app\models\Klas;
use app\models\KlasSearch;
use app\models\KlasVakDocent;
use app\models\LeerjaarVak;
use app\models\School;
use app\models\SchoolSearch;
use app\models\Student;
use app\models\StudentCijfer;
use app\models\StudentCijferSearch;
use app\models\UsersType;
use app\models\Vak;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\SqlDataProvider;

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
//    public function actionCijfer()
//    {
//        $searchModel = new LinkSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('cijfer', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    public function actionKlas()
    {
        $searchModel = new KlasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('klas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSchool()
    {
        $searchModel = new SchoolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $persid = Yii::$app->user->id;
        $docent_naam = UsersType::find()->where(['name' => 'Docent'])->one();
        $docentid = $docent_naam->id;
        $user_type = Yii::$app->user->identity->functie;

        $currentmonth = date('m');
        $currentyear = date('Y');

        if($currentmonth <= 10){

            $yearPrefix = '%'.$currentyear ;
            $yearPrefix = $currentyear -1 .'-'. $currentyear;

        }else{
            $yearPrefix = $currentyear. '%' ;
        }

        if($docentid == $user_type) {
            $dataProvider->query->select(['school.Klas', 'jaar.naam','school.vak_id','school.leerjaar_id','school.klas_id'])
                ->innerJoin('jaar', 'school.schooljaar_id = jaar.jaar_id')
                ->where(['jaar.naam'=> $yearPrefix])
                ->andWhere(['Vakdocent'=> $persid])
            ;



        }else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
        $schooljaar = Jaar::findOne($yearPrefix)->jaar_id;

//var_dump($dataProvider);
        return $this->render('school', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'currentmonth' => $schooljaar,
        ]);
    }

    public function actionSchoolUpdate($schoolid)
    {
        $this->layout = 'main-empty';
        // Load all student models for the given school ID
        $models = StudentCijfer::find()->where(['klas_id' => $schoolid])->all();

        // Check if the form is submitted
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('Studentcijfer'); // Get the form data

            // Flag to track if all models are saved successfully
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
                Yii::$app->session->setFlash('success', 'Data saved successfully.');
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
                    $allvak = LeerjaarVak::find()->where(['leerjaar_id' => $model->leerjaar_id])->all();
//                    $allvak = LeerjaarVak::findAll($model->leerjaar_id);
//                    var_dump($model->leerjaar_id);
//                    var_dump($allvak);
//                    die();

                    foreach ($allvak as $vak) {
                        $newModel = new School();
                        $newModel->Klas = $model->Klas;
                        $newModel->vak_id = $vak->vak_id;
                        $newModel->leerjaar_id = $model->leerjaar_id;
                        $newModel->schooljaar_id = $model->schooljaar_id;
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
            }
        }
    }

    public function actionKlasUpdate($klasid)
    {
        $request = Yii::$app->request;
        $model = School::findOne($klasid);

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
                foreach ($allklas as $klasObj) {
                    $klas_id = $klasObj->klas_id;
                    foreach ($model['student'] as $art) {
                        if (!empty($art['naam']) && !empty($art['voornaam'])) {
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
                                $nartikel->save();
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
            $model->delete();


            return $this->redirect(['school-update', 'schoolid' => $schoolid]);

        }

        public function actionStudent(){
            $searchModel = new StudentCijferSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $dataProvider->query->select([
                'ANY_VALUE(student_id) AS student_id',
                'ANY_VALUE(school.klas_id) AS klas_id',
                'school.Klas AS klas',
                'ANY_VALUE(no) AS no',
                'naam',
                'voornaam',
                'ANY_VALUE(m1t1) AS m1t1',
                'ANY_VALUE(m1t2) AS m1t2',
                'ANY_VALUE(m2t1) AS m2t1',
                'ANY_VALUE(m2t2) AS m2t2',
                'ANY_VALUE(m3t1) AS m3t1',
                'ANY_VALUE(m3t2) AS m3t2',
                'ANY_VALUE(m1h1) AS m1h1',
                'ANY_VALUE(m1h2) AS m1h2',
                'ANY_VALUE(m1h3) AS m1h3',
                'ANY_VALUE(m1h4) AS m1h4',
                'ANY_VALUE(m2h1) AS m2h1',
                'ANY_VALUE(m2h2) AS m2h2',
                'ANY_VALUE(m2h3) AS m2h3',
                'ANY_VALUE(m2h4) AS m2h4',
                'ANY_VALUE(m3h1) AS m3h1',
                'ANY_VALUE(m3h2) AS m3h2',
                'ANY_VALUE(m3h3) AS m3h3',
                'ANY_VALUE(m3h4) AS m3h4',
                'ANY_VALUE(gehaald) AS gehaald',
                'ANY_VALUE(opmerking) AS opmerking',
                'ANY_VALUE(voldoende) AS voldoende',
                'ANY_VALUE(her1) AS her1',
                'ANY_VALUE(her2) AS her2',
                'ANY_VALUE(her3) AS her3',
            ])
                ->innerJoin('school', 'studentcijfer.klas_id = school.klas_id')
                ->groupBy(['school.Klas', 'naam', 'voornaam']);



            return $this->render('student', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

    public function actionStudentRapport($studentid)
    {
        $db = Yii::$app->db;
        $this->layout = 'main-empty';

        try {
            $student = StudentCijfer::findOne($studentid);
            $naam = $student->naam;
            $voornaam = $student->voornaam;
            $klas_id = $student->klas_id;
            $klas = School::findOne($klas_id)->Klas;


            $command = $db->createCommand("
            SELECT a.naam, a.voornaam, a.m1t1, a.m1t2, a.m2t1, a.m2t2, a.m3t1, a.m3t2, b.klas, c.vak, b.leerjaar_id, d.naam as leerjaar
            FROM studentcijfer a
            INNER JOIN school b ON a.klas_id = b.klas_id
            INNER JOIN vak c ON b.vak_id = c.vak_id
            INNER JOIN leerjaar d ON b.leerjaar_id = d.leerjaar_id
            WHERE a.naam = :naam
            AND a.voornaam = :voornaam
            AND b.Klas = :klas
        ");
//                $command = $db->createCommand("
//            SELECT a.naam, a.voornaam, a.m1t1, a.m1t2, b.klas, c.vak, b.leerjaar_id, d.naam as leerjaar
//            FROM studentcijfer a
//            INNER JOIN school b ON a.klas_id = b.klas_id
//            INNER JOIN vak c ON b.vak_id = c.vak_id
//            INNER JOIN leerjaar d ON b.leerjaar_id = d.leerjaar_id
//            WHERE a.naam LIKE ':naam'
//            AND b.Klas = :klas
//        ");
//
            

            $command->bindValues([
                ':naam' => $naam,
                ':voornaam' => $voornaam,
                ':klas' => $klas,
            ]);

            $results = $command->queryAll();

            // Check if there are any results
            if (empty($results)) {
                // No results found
                echo "No data found for the student.";
                // You can also log this information or handle it in any other way you prefer.
            }
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            // Handle the error, perhaps return a user-friendly message.
            $results = [];
        }
//        var_dump($results);
//        var_dump($voornaam);

        return $this->render('rapport_form', [
            'results' => $results,
        ]);
    }

    // In your actionStudentUpdate method
    public function actionStudentUpdate($studentid){
        $this->layout = 'main-empty';

        // Fetch the student
        $student = StudentCijfer::findOne($studentid);
        $naam = $student->naam;

        // Fetch the student's class
        $klas_id = $student->klas_id;
        $klas = School::findOne($klas_id)->Klas;

        // Fetch all subjects for the student's class
        $allklas = School::find()->where(['Klas'=> $klas])->all();

        // Fetch the grades for the student in the current class
        $cijfers = StudentCijfer::find()->where(['naam' => $naam, 'klas_id' => $klas_id])->all();

        // Handle form submission
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
                    }
                }
            }
        }


        return $this->render('student_update_form', [
            'allklas' => $allklas,
            'student' => $student,
            'cijfers' => $cijfers,
            'klas_id' => $klas_id,
        ]);
    }



    public function actionSaveGrades()
    {
        // Check if the request is POST
        if (Yii::$app->request->isPost) {
            // Get the posted form data
            $postData = Yii::$app->request->post();

            // Iterate over each student ID and associated grade
            foreach ($postData['Studentcijfer'] as $studentId => $grades) {
                // Find the corresponding StudentCijfer model
                $studentCijfer = StudentCijfer::findOne($studentId);

                // Check if the model exists
                if ($studentCijfer !== null) {
                    // Update the grades for the student
                    $studentCijfer->load($grades, '');
                    // Validate and save the model
                    if (!$studentCijfer->validate() || !$studentCijfer->save()) {
                        // Handle validation or save errors
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

        return $this->render('moederlijst', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionMoederlijstView($klas_id)
    {
        $this->layout = 'main-empty';

        $klas = School::findOne($klas_id)->Klas;

        // Fetch all classes
        $allklas = School::find()->where(['Klas' => $klas])->all();

// Initialize an empty array to store all grades
        $allCijfers = [];

// Loop through each class
        foreach ($allklas as $class) {
            // Get the class ID and vak ID
            $classId = $class->klas_id;
            $vakId = $class->vak_id;

            // Fetch the grades for students in the current class
            $cijfers = StudentCijfer::find()->where(['klas_id' => $classId])->all();

            // Add vak ID to each grade and merge into the array
            foreach ($cijfers as $cijfer) {
                $cijfer->vak_id = $vakId; // Add vak ID to the cijfer object
                $allCijfers[] = $cijfer;   // Add the cijfer object to the array
            }
        }
        return $this->render('moederlijst_form', [
            'allklas' => $allklas,
            'allCijfers' => $allCijfers,
            'klas_id' => $klas_id

        ]);
    }






//    public function actionArtikelenCreate($id)
//    {
//        $request = Yii::$app->request;
//        $modelartikelen = new MeldingArtikel();
//        $modelartikelen->meldingid = $id;
//        $keyid = Melding::findOne($id)->keyid;
//
//        if ($request->isAjax) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            if ($request->isGet) {
//                return [
//                    'size' => 'large',
//                    'title' => "Artikelen",
//                    'content' => $this->renderAjax('artikelen_form', [
//                        'modelartikelen' => $modelartikelen,
//                    ]),
//                    'footer' => Html::button('Close', ['class' => 'btn btn-secondary pull-left', 'data-dismiss' => "modal"]) .
//                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
//
//                ];
//            } else if ($modelartikelen->load($request->post())) {
//
//                foreach ($modelartikelen['artikel'] as $art) {
//                    if ($art['artikelid'] || $art['omsch'] || $art['voltooid']) {
//                        $nartikel = new MeldingArtikel();
//                        $nartikel->meldingid = $modelartikelen->meldingid;
//                        $nartikel->artikelid = $art['artikelid'];
//                        $nartikel->omsch = $art['omsch'];
//                        $nartikel->voltooid = $art['voltooid'];
//                        $nartikel->save();
//                    }
//                };
//            }
//            return [
//                'content'=> 'Reloading...',
//                'footer'=> '<script>window.location.href = "meldingen-update?keyid='.$keyid.'";</script>'
//
//            ];
//        } else {
//            return [
//                'size' => 'large',
//                'title' => "Artikelen",
//                'content' => $this->renderAjax('artikelen_form', [
//                    'modelartikelen' => $modelartikelen,
//                ]),
//                'footer' => Html::button('Close', ['class' => 'btn btn-secondary pull-left', 'data-dismiss' => "modal"]) .
//                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
//            ];
//        }
//    }
//    public function actionKlasCreate()
//    {
//        $request = Yii::$app->request;
//        $model = new Klas();
//
//        if($request->isAjax){
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            if($request->isGet){
//                return [
//                    'size'=> 'large',
//                    'title'=> "Nieuw Boek",
//                    'content'=>$this->renderAjax('klas_form', [
//                        'model' => $model,
//                    ]),
//                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
//                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
//
//                ];
//            }else if($model->load($request->post()) && $model->save()){
//                return [
//                    'forceClose'=>true,
//                    'forceReload'=>'#crud-datatable-pjax',
//                ];
//            }else{
//                return [
//                    'size'=> 'large',
//                    'title'=> "Nieuw Boek",
//                    'content'=>$this->renderAjax('klas_form', [
//                        'model' => $model,
//                    ]),
//                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
//                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
//
//                ];
//            }
//        }
//    }
//
//    public function actionKlasUpdate($klasid)
//    {
//        $student = null;
//        $cijfer = null;
//        $vak_docent = null;
//
//        $request = Yii::$app->request;
//        $model = Klas::findOne($klasid);
//        $link_table = CijferKlas::find()->where(['klas_id' => $klasid])->All();
//        foreach ($link_table as $link) {
//            $student = Student::find()->where(['student_id' => $link->student_id])->One();
//            $cijfer = StudentCijfer::find()->where(['cijfer_id' => $link->cijfer_id])->One();
//            $vak_docent = KlasVakDocent::find()->where(['klas_id'=> $klasid])->One();
//        }
//            if($request->isGet){
//                return $this->render('klas_form', [
//                    'model' => $model,
//                    'student'=> $student,
//                    'cijfer'=> $cijfer,
//                    'vak_docent'=> $vak_docent,
//                ]);
//            }else if($model->load($request->post()) && $model->save()){
////
////                var_dump($cijfer);
////                die();
//                foreach ($student as $student) {
//                    $student->load($request->post());
//                    $student->save();
//                }
//
//                foreach ($cijfer as $cijfer) {
//                    $cijfer->load($request->post());
//                    $cijfer->save();
//                }
//                return [
//                    'forceClose'=>true,
//
//                ];
//            }else{
//                 return $this->render('klas_form', [
//                    'model' => $model,
//                     'student'=> $student,
//                     'cijfer'=> $cijfer,
//                     'vak_docent'=> $vak_docent,
//                ]);
//            }
//        }


    /**
     * Displays a single Link model.
     * @param integer $id
     * @return mixed
     */
//    public function actionView($id)
//    {
//        $request = Yii::$app->request;
//        if($request->isAjax){
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return [
//                    'title'=> "Link #".$id,
//                    'content'=>$this->renderAjax('view', [
//                        'model' => $this->findModel($id),
//                    ]),
//                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
//                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
//                ];
//        }else{
//            return $this->render('view', [
//                'model' => $this->findModel($id),
//            ]);
//        }
//    }
//
//    /**
//     * Creates a new Link model.
//     * For ajax request will return json object
//     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
//     * @return mixed
//     */
//    public function actionCreate()
//    {
//        $request = Yii::$app->request;
//        $model = new Link();
//
//        if($request->isAjax){
//            /*
//            *   Process for ajax request
//            */
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            if($request->isGet){
//                return [
//                    'title'=> "Create new Link",
//                    'content'=>$this->renderAjax('create', [
//                        'model' => $model,
//                    ]),
//                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
//                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
//
//                ];
//            }else if($model->load($request->post()) && $model->save()){
//                return [
//                    'forceReload'=>'#crud-datatable-pjax',
//                    'title'=> "Create new Link",
//                    'content'=>'<span class="text-success">Create Link success</span>',
//                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
//                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
//
//                ];
//            }else{
//                return [
//                    'title'=> "Create new Link",
//                    'content'=>$this->renderAjax('create', [
//                        'model' => $model,
//                    ]),
//                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
//                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
//
//                ];
//            }
//        }else{
//            /*
//            *   Process for non-ajax request
//            */
//            if ($model->load($request->post()) && $model->save()) {
//                return $this->redirect(['view', 'id' => $model->link_id]);
//            } else {
//                return $this->render('create', [
//                    'model' => $model,
//                ]);
//            }
//        }
//
//    }
//
//    /**
//     * Updates an existing Link model.
//     * For ajax request will return json object
//     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionUpdate($id)
//    {
//        $request = Yii::$app->request;
//        $model = $this->findModel($id);
//
//        if($request->isAjax){
//            /*
//            *   Process for ajax request
//            */
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            if($request->isGet){
//                return [
//                    'title'=> "Update Link #".$id,
//                    'content'=>$this->renderAjax('update', [
//                        'model' => $model,
//                    ]),
//                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
//                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
//                ];
//            }else if($model->load($request->post()) && $model->save()){
//                return [
//                    'forceReload'=>'#crud-datatable-pjax',
//                    'title'=> "Link #".$id,
//                    'content'=>$this->renderAjax('view', [
//                        'model' => $model,
//                    ]),
//                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
//                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
//                ];
//            }else{
//                 return [
//                    'title'=> "Update Link #".$id,
//                    'content'=>$this->renderAjax('update', [
//                        'model' => $model,
//                    ]),
//                    'footer'=> Html::button('Close',['class'=>'btn btn-secondary pull-left','data-dismiss'=>"modal"]).
//                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
//                ];
//            }
//        }else{
//            /*
//            *   Process for non-ajax request
//            */
//            if ($model->load($request->post()) && $model->save()) {
//                return $this->redirect(['view', 'id' => $model->link_id]);
//            } else {
//                return $this->render('update', [
//                    'model' => $model,
//                ]);
//            }
//        }
//    }
//
//    /**
//     * Delete an existing Link model.
//     * For ajax request will return json object
//     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionDelete($id)
//    {
//        $request = Yii::$app->request;
//        $this->findModel($id)->delete();
//
//        if($request->isAjax){
//            /*
//            *   Process for ajax request
//            */
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
//        }else{
//            /*
//            *   Process for non-ajax request
//            */
//            return $this->redirect(['index']);
//        }
//
//
//    }
//
//     /**
//     * Delete multiple existing Link model.
//     * For ajax request will return json object
//     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionBulkdelete()
//    {
//        $request = Yii::$app->request;
//        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
//        foreach ( $pks as $pk ) {
//            $model = $this->findModel($pk);
//            $model->delete();
//        }
//
//        if($request->isAjax){
//            /*
//            *   Process for ajax request
//            */
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
//        }else{
//            /*
//            *   Process for non-ajax request
//            */
//            return $this->redirect(['index']);
//        }
//
//    }
//
//    /**
//     * Finds the Link model based on its primary key value.
//     * If the model is not found, a 404 HTTP exception will be thrown.
//     * @param integer $id
//     * @return Link the loaded model
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    protected function findModel($id)
//    {
//        if (($model = Link::findOne($id)) !== null) {
//            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
//    }
}
