<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialRangoHorario */
?>
<div class="historial-rango-horario-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'hora_inicio',
            'hora_final',
            'fecha',
        ],
    ]) ?>

</div>
