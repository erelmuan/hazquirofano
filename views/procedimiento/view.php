<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimiento */
?>
<div class="procedimiento-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'descripcion',
            'codigo',
            'id',
        ],
    ]) ?>

</div>
