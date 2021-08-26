<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Semana */
?>
<div class="semana-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'dia',
        ],
    ]) ?>

</div>
