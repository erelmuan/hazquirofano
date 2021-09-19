<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Quirofano */
?>
<div class="quirofano-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'observacion',
            'habilitado:boolean',
            [
              'label'=>'Anestesiologo',
              'value'=> ($model->anestesiologo)?$model->anestesiologo->nombre:'No definido',

            ]

        ],
    ]) ?>

</div>
