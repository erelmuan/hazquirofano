<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
return [

        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'observacion',
    ],
    [
      'class'=>'\kartik\grid\BooleanColumn',
      'attribute'=>'habilitado',
  ],
  [
      //nombre
      'class'=>'\kartik\grid\DataColumn',
      'label'=> 'Anestesiologo',
      'attribute'=>'anestesiologo',
      'width' => '170px',
      'value' => function($model) {
          //var_dump ($key);
          if ($model->anestesiologo){
              return Html::a( $model->anestesiologo->nombre,['anestesiologo/view',"id"=> $model->anestesiologo->id]
                ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del anestesiologo','data-toggle'=>'tooltip']
               );
         }else {
           return 'No definido';
         }
             }
             ,
             'filterInputOptions' => ['placeholder' => 'Ingrese nombre','class'=>"form-control"],
             'format' => 'raw',

    ],
  [
    'class'=>'\kartik\grid\DataColumn',
    'label'=>'Anestesiologo',
    'attribute'=>'id_anestesiologo',
    'value'=>'anestesiologo.nombre'
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
        'updateOptions'=>['title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];
