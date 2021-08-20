<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Cirugiaprogramada */
?>
<div class="cirugiaprogramada-view">

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

  </div>
</div>
