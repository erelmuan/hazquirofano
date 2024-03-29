<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [

        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'usuario.usuario',
        'width' => '170px',
        'value' => function($dataProvider, $key, $index, $widget) {
            $key = str_replace("[","",$key);
            $key = str_replace("]","",$key);
            //var_dump ($key);
          return Html::a( $dataProvider->usuario->usuario, ['usuario/view',"id"=> $dataProvider->usuario->id]

            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
           );

         }
         ,

         'filterInputOptions' => ['placeholder' => 'Ingrese Dni,HC o nombre'],
         'format' => 'raw',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'accion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tabla',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecha',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hora',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ip',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'informacion_usuario',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'cambios',
    //      'format' => 'raw',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view}',

        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip' ],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Eliminar',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];
