<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\WiewQuirofanosDisponibles */
?>
<div class="wiew-quirofanos-disponibles-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fecha_cirugia',
            'hora_inicio',
            'hora_final',
            'id_quirofano',
            'descripcion:ntext',
        ],
    ]) ?>

</div>
