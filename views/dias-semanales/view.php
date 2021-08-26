<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DiasSemanales */
?>
<div class="dias-semanales-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'dia',
            'habilitado:boolean',
        ],
    ]) ?>

</div>
