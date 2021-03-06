<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Equipo;
 $columns=[
          [
          'class'=>'\kartik\grid\DataColumn',
          'attribute'=>'id',
      ],
      [
        'attribute' => 'id_quirofano',
        'label' => 'Quirofano',
        'value' => 'quirofano.nombre',
        'filter'=>$searchModel->getQuirofanos(),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => ['allowClear' => true],
        ],
      ],
      [
          'class'=>'\kartik\grid\DataColumn',
          'attribute'=>'hora_inicio',
      ],
    [
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'label'=> 'Paciente',
        'attribute'=>'paciente',

        'width' => '170px',
        //creo que no hacer falta ni key ni indez tampoco widget
        'value' => function($model) {
          return Html::a( $model->paciente->nombre .' '.$model->paciente->apellido,['paciente/view',"id"=> $model->paciente->id]

            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
           );

         }
         ,

         'filterInputOptions' => ['placeholder' => 'Ingrese Dni o apellido','class'=>"form-control"],
         'format' => 'raw',

    ],
    [
      'class'=>'\kartik\grid\DataColumn',
      'label'=> 'Edad',
        'value' => function($model) {
            list($ano,$mes,$dia) = explode("-",$model->paciente->fecha_nacimiento);
            list($anoR,$mesR,$diaR) = explode("-",$model->fecha_cirugia);


            $ano_diferencia  = $anoR - $ano;
            $mes_diferencia = $mesR - $mes;
            $dia_diferencia   = $diaR - $dia;
            if ( $mes_diferencia < 0)
            {
              $ano_diferencia--;
            }
            elseif ( $mes_diferencia == 0){
              if ( $dia_diferencia < 0)
                  $ano_diferencia--;
              }
              return $ano_diferencia;
            }

    ],
      [
          //nombre
          'class'=>'\kartik\grid\DataColumn',
          'value'=>function($model) {
          return  $model->paciente->num_documento;
        },
          'label'=> 'DNI'
      ],
      [
          //nombre
        'class'=>'\kartik\grid\DataColumn',
        'value'=>function($model) {
        return  $model->paciente->hc;
      },
        'label'=> 'HC'
      ],

          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'diagnostico',
          ],
          [
              //nombre
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'procedimiento',
            'label'=> 'Procedimiento'
          ],
    [
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'label'=> 'Cirujano',
        'attribute'=>'medico',
        'width' => '170px',
        'value' => function($model) {
          return Html::a( $model->medico->nombre .' '.$model->medico->apellido,['medico/view',"id"=> $model->medico->id]
            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
           );
               }
               ,
               'filterInputOptions' => ['placeholder' => 'Ingrese Dni o apellido','class'=>"form-control"],
               'format' => 'raw',

      ],
      [
          'class'=>'\kartik\grid\DataColumn',
          'attribute'=>'ayudantes',
      ],

      [
        'attribute' => 'id_anestesia',
        'label' => 'Anestesia',
        'value' => 'anestesia.descripcion',
        'filter'=>$searchModel->getAnestesias(),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
      [
          'class'=>'\kartik\grid\DataColumn',
          'attribute'=>'fecha_cirugia',
          'format' => ['date', 'd/M/Y'],
      ],


    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cant_tiempo',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'lado',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecha_programada',
        'format' => ['date', 'd/M/Y'],
    ],


    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'material_protesis',
    ],
    [
      'attribute' => 'id_estado',
      'label' => 'Estado',
      'value' => 'estado.descripcion',
      'filter'=>$searchModel->getEstados(),
      'filterType' => GridView::FILTER_SELECT2,
      'filterWidgetOptions' => [
          'options' => ['prompt' => ''],
          'pluginOptions' => ['allowClear' => true],
      ],
  ],


  [
      'format'    => 'html',
      'label' => 'Observaciones',
      'value'     => function($model)
      {
          $items = "";
          $cant=1;
          foreach ($model->observacionCirugias as $observacion) {

              $items .="<b>".$cant.":</b>". $observacion->observacionquirurgica->descripcion."<br>";
              $cant++;
          }
          return $items;
      }
  ],

  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'otro_equpo',
  ],
  [
      'class'=>'\kartik\grid\DataColumn',
      'label'=>'Detalles',
      'attribute'=>'observacion',
  ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{update} {view}',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['title'=>'Editar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Borrar',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];
//esto se tiene que hacer desde el controlador(invocar al modelo), despues corregir!!!
function devolver(){
  return false;
};
$dateColumns= Equipo::find()->all();
  // var_dump ($dataProvider);
foreach($dateColumns  as $date){

  $columns[] = [
      'class'=>'\kartik\grid\DataColumn',
      'label'=>$date->descripcion,
      'format'    => 'html',
      'value'  => function ($model)use ($date) {
        $usado="";
        foreach ($model->cirugiaequipos as $cirequipo) {
            if ($cirequipo->equipo->descripcion==$date->descripcion ){
              $usado= "Usado";
                break;
            }
          }
          return $usado;
        },
    ];
}
return $columns;
