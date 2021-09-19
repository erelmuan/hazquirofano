<?php
use yii\helpers\Url;
use kartik\grid\GridView;
return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'descripcion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'dias',
    ],
      [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'activo',
    ],
    [
      'attribute' => 'id_especialidad',
      'label' => 'Especialidad',
      'value' => 'especialidad.profesion',
      'filter'=>$searchModel->getEspecialidades(),
      'filterType' => GridView::FILTER_SELECT2,
      'filterWidgetOptions' => [
          'options' => ['prompt' => ''],
          'pluginOptions' => ['allowClear' => true],
      ],
  ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Editar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Borrar',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Esta seguro?',
                          'data-confirm-message'=>'¿ Desea borrar este registro ?'],
    ],

];
