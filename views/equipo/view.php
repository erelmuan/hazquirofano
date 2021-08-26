<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Equipo */
?>
<div class="equipo-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
            'dias',
            'activo:boolean',
        ],
    ]) ?>

</div>
