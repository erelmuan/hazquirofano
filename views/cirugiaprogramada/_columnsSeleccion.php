<?php
use yii\helpers\Url;

return [
    // [
    //     'class' => '\kartik\grid\RadioColumn',
    //     'width' => '20px',
    //     'radioOptions' => function ($model) {
    //                   return ['value' => $model->id];
    //              }
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'id',
    //     'hidden' => true
    // ],
    SUGERENCIA HACER UNA VISTAAAAA
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
        'attribute'=>'quirofano.nombre',
        'label'=> 'Quirofano'
    ],

    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'idplantillamaterialb',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecharealizacion',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fechadeingreso',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'estudio',
    // ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Eliminar',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];
