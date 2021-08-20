<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\TimePicker;
use yii\widgets\MaskedInput;



return [

  [
      'class' => 'kartik\grid\SerialColumn',
      'width' => '30px',
  ],

  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'fecha_cirugia',
      'format' => ['date', 'd/M/Y'],
      'filterType' => MaskedInput::classname(),

      'filterWidgetOptions' => [

        'clientOptions' => ['alias' =>  'dd/mm/yyyy']
          ],
  ],
  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'hora_inicio',
       'format' => ['time', 'php: H:i:s'],
       'filterType' => MaskedInput::classname(),

       'filterWidgetOptions' => [
          'mask' => '99:99:00'
           ],
  ],

  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'hora_final',
      'format' => ['time', 'php: H:i:s'],
      'filterType' => MaskedInput::classname(),

      'filterWidgetOptions' => [
         'mask' => '99:99:00'
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


  // [
  //     'class'=>'\kartik\grid\DataColumn',
  //     'attribute'=>'descripcion',
  // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'descripcion',
    // ],


];
