<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Cirugiaprogramada */
?>
<div class="cirugiaprogramada-view">
    <div id="w0s" class="x_panel">
      <div class="x_title"><h2><i class="fa fa-table"></i> CIRUGIA PROGRAMADA  </h2>
        <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Ir a Cirugias programadas', ['/cirugiaprogramada/index'], ['class'=>'btn btn-danger grid-button']) ?></div>
    </div>
      </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
              'value'=> $model->paciente->apellido .' '.$model->paciente->nombre,
              'label'=> 'Paciente',
           ],
             [
               'value'=> $model->medico->apellido .' '.$model->medico->nombre,
               'label'=> 'Medico',
            ],
            [
              'value'=> $model->procedimiento ,
              'label'=> 'Procedimientos',
           ],
            [
              'value'=> $model->anestesia->descripcion ,
              'label'=> 'Anestesia',
           ],
            [
              'value'=> $model->fecha_programada ,
              'label'=> 'Fecha de programada',
              'format' => ['date', 'd/M/Y'],

           ],
           [
             'value'=> $model->fecha_cirugia ,
             'label'=> 'Fecha de cirugia',
             'format' => ['date', 'd/M/Y'],
          ],
            'hora_inicio',
            'cant_tiempo',
            'ayudantes',
            'lado',

            'observacion:ntext',
            'diagnostico',
            [
              'value'=> $model->quirofano->nombre ,
              'label'=> 'Quirofano',
           ],
            'material_protesis:ntext',
            [
            'attribute' => 'Equipos',
                'format'    => 'html',
                'value'     => call_user_func(function($model)
                {
                    $items = "";
                    $cant=1;
                    foreach ($model->cirugiaequipos as $cirequpo) {

                        $items .="<b>".$cant.":</b>". $cirequpo->equipo->descripcion."<br>";
                        $cant++;
                    }
                    return $items;
                }, $model)
            ],

            'otro_equpo',
            [
            'attribute' => 'Observaciones',
                'format'    => 'html',
                'value'     => call_user_func(function($model)
                {
                    $items = "";
                    $cant=1;
                    foreach ($model->observacionCirugias as $obs_cir) {

                        $items .="<b>".$cant.":</b>". $obs_cir->observacionquirurgica->descripcion."<br>";
                        $cant++;
                    }
                    return $items;
                }, $model)
            ],
            [
              'value'=> $model->estado->descripcion ,
              'label'=> 'Estado',
           ],
        ],
    ]) ?>
    <?

    echo Html::a('<i class="fa fa-file-pdf-o"></i> Generar PDF', ['/cirugiaprogramada/informe', 'id' => $model->id], [
          'class'=>'btn btn-danger',
          'target'=>'_blank',
          'data-toggle'=>'tooltip',
          'title'=>'Se abrirá el archivo PDF generado en una nueva ventana'
      ]);
    ?>

  </div>

</div>
