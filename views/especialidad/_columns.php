<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\Html;
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
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
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
        'attribute'=>'profesion',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Borrar',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Esta seguro?',
                          'data-confirm-message'=>'¿ Desea borrar este registro ?'],

    ],

];
