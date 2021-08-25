<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\WiewHorasOcupadas */
?>
<div class="wiew-horas-ocupadas-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fecha_cirugia',
            'horas_ocupadas',
            'id_quirofano',
            'descripcion:ntext',
        ],
    ]) ?>

</div>
