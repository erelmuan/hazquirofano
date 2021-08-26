<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Parametrizacion */
?>
<div class="parametrizacion-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'hora_inicio',
            'hora_final',
            'horario_minimo',
            'dias_anticipacion',
            'dias_creacion',
        ],
    ]) ?>

</div>
