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
            'attribute' => 'Anestesiologo',
                'format'    => 'html',
                'value'     => call_user_func(function($model)
                {
                    $items = "";
                    $cant=1;
                    foreach ($model->quirofanoAnestesiologos as $quirofanoAnestesiologo) {

                        $items .="<b>".$cant." : </b>". $quirofanoAnestesiologo->anestesiologo->nombre."<br>";
                        $cant++;
                    }
                    return $items;
                }, $model)
            ],
            'necesita_anestesiologo:boolean',


        ],
    ]) ?>

</div>
