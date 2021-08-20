<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Anestesia */
?>
<div class="anestesia-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
        ],
    ]) ?>

</div>
