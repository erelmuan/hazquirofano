<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Quirofano */
?>
<div class="cirugiaprogramada-view">
    <div id="w0s" class="x_panel">
      <div class="x_title"><h2><i class="fa fa-table"></i> QUIROFANO  </h2>
        <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Ir a quirofano', ['/quirofano/index'], ['class'=>'btn btn-danger grid-button']) ?></div>
    </div>
      </div>
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

                        $items .="<b>".$cant.":</b>". $quirofanoAnestesiologo->anestesiologo->nombre."<br>";
                        $cant++;
                    }
                    return $items;
                }, $model)
            ],
           'necesita_anestesiologo:boolean',

        ],
    ]) ?>

</div>
</div>
