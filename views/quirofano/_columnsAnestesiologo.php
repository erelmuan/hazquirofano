<?php
use yii\helpers\Url;

return [

  [
      'class' => '\kartik\grid\RadioColumn',
      'width' => '20px',
  ],
  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'id',
      'hidden' => true
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

                foreach ($model->anestesiologoSemanas as $dia_sem) {

                    $items .="<b>".$cant.":</b>". $dia_sem->semana->dia."<br>";
                    $cant++;
                }
                return $items;

            }
        ],

];
