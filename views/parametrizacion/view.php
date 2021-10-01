<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Parametrizacion */
?>
  <div class="parametrizacion-view">
      <div id="w0s" class="x_panel">
        <div class="x_title"><h2><i class="fa fa-table"></i> CIRUGIA PROGRAMADA  </h2>
          <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Ir a parametrización', ['/parametrizacion/update','id'=>'1'], ['class'=>'btn btn-danger grid-button']) ?></div>
      </div>
        </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'hora_inicio',
            'hora_final',
            'horario_minimo',
            'dias_anticipacion',
            'dias_creacion',
        ],
    ]) ?>

</div>
</div>
