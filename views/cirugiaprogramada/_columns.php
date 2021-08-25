<?php
use yii\helpers\Url;
use yii\helpers\Html;
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
          //nombre
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'anestesia.descripcion',
        'label'=> 'Anestesia'
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
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ayudantes',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'lado',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecha_cirugia',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'observacion',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'diagnostico',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id_quirofano',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'material_protesis',
    // ],
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
