<?php

use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Barcodelog */
?>
<div class="gebruiker-view">

    <?= DetailView::widget([
        'model'=>$model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'attributes'=>[
            'username',
            'name',
            'email',
            'users_type_id',
            'active',
        ]
    ]) ?>

</div>
