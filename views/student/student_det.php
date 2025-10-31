<?php

use hoaaah\ajaxcrud\CrudAsset;
use yii\bootstrap4\Modal;

CrudAsset::register($this);
?>
<div class="row">
    <div class="col-xl-12">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-artikelen<?=$id?>" role="tabpanel" aria-labelledby="pills-artikelen<?=$id?>-tab">
                <div class="card radius-10 overflow-hidden">
                    <div class="card-body">
                        <?= $this->render('student_klas.php',[
                            'id'=>$id
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>