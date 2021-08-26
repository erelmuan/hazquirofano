<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Semanaespecialidad */
?>
<div class="semanaespecialidad-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_semana',
            'id_especialidad',
        ],
    ]) ?>

</div>
