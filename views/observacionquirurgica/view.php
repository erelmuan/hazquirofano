<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Observacionquirurgica */
?>
<div class="observacionquirurgica-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
            'activo:boolean',
        ],
    ]) ?>

</div>
