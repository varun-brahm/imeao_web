<?php

use hoaaah\ajaxcrud\CrudAsset;
use yii\bootstrap4\Modal;
$klas = \app\models\Schooljaar::findOne($id);
$studenten = \app\models\Schooljaar::find()->where(['huidige_klas'=>$klas->huidige_klas,'schooljaar'=>$klas->schooljaar])->all();
$ids = \yii\helpers\ArrayHelper::getColumn($studenten, 'IDstudent');
CrudAsset::register($this);
?>
<div class="row">
    <div class="col-xl-12">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-artikelen<?=$id?>" role="tabpanel" aria-labelledby="pills-artikelen<?=$id?>-tab">
                <div class="card radius-10 overflow-hidden">
                    <div class="card-body">
                        <?= $this->render('student_algeheel_klas.php',[
                            'id'=>$id,
                            'ids'=>$ids,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>