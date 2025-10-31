<?php

namespace app\controllers;

use app\models\Jaar;
use app\models\School;
use app\models\StudentCijfer;
use app\models\Vak;
use yii\filters\AccessControl;

class DashboardController extends \yii\web\Controller
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

    public function actionStartpagina()
    {
//        $fields = [
//            'm1t1', 'm1t2', 'm2t1', 'm2t2', 'm3t1', 'm3t2',
//            'm1h1', 'm1h2', 'm1h3', 'm1h4',
//            'm2h1', 'm2h2', 'm2h3', 'm2h4',
//            'm3h1', 'm3h2', 'm3h3', 'm3h4',
//            'her1', 'her2', 'her3'
//        ];
//
//        $currentmonth = date('m');
//        $currentyear = date('Y');
//
//        if ($currentmonth <= 10) {
//            $yearPrefix = ($currentyear - 1) . '-' . $currentyear;
//        } else {
//            $yearPrefix = $currentyear . '-' . ($currentyear + 1);
//        }
//
//        $schooljaar = Jaar::find()->where(['naam' => $yearPrefix])->one();
//
//        $klassen = School::find()
//            ->select([
//                'klas_id',
//                'Klas',
//                'vak_id' => 'MAX(vak_id)' // choose one vak_id for that klas
//            ])
//            ->where(['schooljaar_id' => $schooljaar->jaar_id])
//            ->groupBy(['klas_id', 'Klas'])
//            ->all();
//
//        $stats = [];
//
//        foreach ($klassen as $klas) {
//            $vakRecords = StudentCijfer::find()
//                ->select(['vak_id'])
//                ->distinct()
//                ->where(['klas_id' => $klas->klas_id])
//                ->all();
//
//            foreach ($vakRecords as $vak) {
//                $geheel = 0;
//                $countGrades = 0;
//
//                // Get all records for this klas+vak
//                $studenten = StudentCijfer::find()
//                    ->where(['klas_id' => $klas->klas_id, 'vak_id' => $vak->vak_id])
//                    ->all();
//
//                foreach ($studenten as $student) {
//                    foreach ($fields as $field) {
//                        $value = $student->$field;
//                        if (is_numeric($value)) {
//                            $geheel += $value;
//                            $countGrades++;
//                        }
//                    }
//                }
//
//                $average = $countGrades > 0 ? $geheel / $countGrades : 0;
//
//                // Store results grouped by klas
//                $stats[$klas->klas_id]['klas'] = $klas->Klas;
//                $stats[$klas->klas_id]['vakdata'][] = [
//                    'vak' => $vak->vak,
//                    'totaal' => $geheel,
//                    'aantal' => $countGrades,
//                    'gemiddelde' => $average,
//                ];
//            }
//        }

        return $this->render('startpagina', [
//            'stats' => $stats,
        ]);

    }



}
