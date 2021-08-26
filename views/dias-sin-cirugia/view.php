<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DiasSinCirugia */
?>
<div class="dias-sin-cirugia-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fecha',
            'motivo',
        ],
    ]) ?>

</div>
