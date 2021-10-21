<?php
use yii\helpers\Url;

return [

        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre',
    ],
    [
      'class'=>'\kartik\grid\DataColumn',

    'attribute' => 'Dias',
        'format'    => 'html',
        'value'     => function($model)
        {
            $items = "";
            $cant=1;
            if($model->id==1){
              return "No inciden los dias.";
            }else {
              foreach ($model->anestesiologoSemanas as $dia_sem) {

                  $items .="<b>".$cant.":</b>". $dia_sem->semana->dia."<br>";
                  $cant++;
              }
              return $items;
            }


        }
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Eliminar',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];
