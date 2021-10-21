<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Anestesiologo */
?>

  <div class="anestesiologo-view">
      <div id="w0s" class="x_panel">
        <div class="x_title"><h2><i class="fa fa-table"></i> ANESTESIOLOGO  </h2>
          <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Ir a Anestesiologos', ['/anestesiologo/index'], ['class'=>'btn btn-danger grid-button']) ?></div>
      </div>
        </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            [
            'attribute' => 'Dias',
                'format'    => 'html',
                'value'     => call_user_func(function($model)
                {
                    $items = "";
                    $cant=1;
                    if($model->id==1){
                      return "No inciden los dias.";
                    }else {
                      foreach ($model->anestesiologoSemanas as $dia_sem) {

                          $items .="<b>".$cant.":</b>". $dia_sem->semana->dia."<br>";
                          $cant++;
                      }
                    }
                    return $items;
                }, $model)
            ],
        ],
    ]) ?>

</div>
</div>
