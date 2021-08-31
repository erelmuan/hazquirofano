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
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'label'=> 'Paciente',
        'attribute'=>'paciente',

        'width' => '170px',
        //creo que no hacer falta ni key ni indez tampoco widget
        'value' => function($dataProvider, $key, $index, $widget) {
            $key = str_replace("[","",$key);
            $key = str_replace("]","",$key);
          return Html::a( $dataProvider->paciente->nombre .' '.$dataProvider->paciente->apellido,['paciente/view',"id"=> $dataProvider->paciente->id]

            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
           );

         }
         ,

         'filterInputOptions' => ['placeholder' => 'Ingrese Dni o apellido','class'=>"form-control"],
         'format' => 'raw',

    ],
    [
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'label'=> 'Medico',
        'attribute'=>'medico',
        'width' => '170px',
        'value' => function($dataProvider, $key, $index, $widget) {
            $key = str_replace("[","",$key);
            $key = str_replace("]","",$key);
            //var_dump ($key);
          return Html::a( $dataProvider->medico->nombre .' '.$dataProvider->medico->apellido,['medico/view',"id"=> $dataProvider->medico->id]
            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
           );
               }
               ,
               'filterInputOptions' => ['placeholder' => 'Ingrese Dni o apellido','class'=>"form-control"],
               'format' => 'raw',

      ],
      [
          //nombre
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'procedimiento',
        'label'=> 'Procedimiento'
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
        'attribute'=>'hora_inicio',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cant_tiempo',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ayudantes',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'lado',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecha_cirugia',
        'format' => ['date', 'd/M/Y'],
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'diagnostico',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_quirofano',
        'attribute'=>'quirofano.nombre',
        'label' => 'Estado',
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
      'format'    => 'html',
      'label' => 'Equipos',
      'value'     => function($model)
      {
          $items = "";
          $cant=1;
          foreach ($model->cirugiaequipos as $cirequipo) {

              $items .="<b>".$cant.":</b>". $cirequipo->equipo->descripcion."<br>";
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

$dateColumns= Equipo::find()->all();
  // var_dump ($dataProvider);
foreach($dateColumns  as $date){

  $false=function($model)
  {
    return false;
  };
  $true=function($model)
  {
    return true;
  };
  $entro=false;
  // var_dump ($searchModel->fecha_cirugia);
  foreach ($searchModel->cirugiaequipos as $cirequipo) {
        var_dump ($searchModel->cirugiaequipos);
      if ($cirequipo->descripcion==$date->descripcion ){
      $entro=true;
      echo "holaaaaaaaaaaaaaaaaaaa";
          break;
      }
  }
  $columns[] = [
      'class'=>'\kartik\grid\BooleanColumn',
      'label'=>$date->descripcion,
        'attribute'=>'observacion',
      // 'value'  =>$entro==true?$valor:$valor,
      // 'value'  =>$entro==true?$true:$false,
      'value'  =>$date->descripcion,
    ];
}
return $columns;
