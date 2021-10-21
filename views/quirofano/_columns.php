<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

return [

  [
    'class' => '\kartik\grid\ExpandRowColumn',
    'value' => function ($model, $key, $index, $column) {
        return GridView::ROW_COLLAPSED;
    },
    'detailUrl' => Url::to(['listdetalle']),   //  action mostrarDetalle con POST expandRowKey como ID
    'detailRowCssClass' => 'expanded-row',
    'expandIcon' => '<i class="glyphicon glyphicon-plus" style="color:black"></i>',
    'collapseIcon' => '<i class="glyphicon glyphicon-minus" style="color:black"></i>',
    'expandOneOnly' => true,
  ],
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
    'class'=>'\kartik\grid\BooleanColumn',
      'attribute'=>'necesita_anestesiologo',
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
