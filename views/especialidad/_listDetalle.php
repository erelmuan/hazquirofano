<?php

use yii\helpers\Html;
use kartik\grid\GridView;

?>

<style>
    .expanded-row > td {
        background-color: #a4cea9;
    }
    .expanded-row > tr {
        background-color: #beedc0;
    }
    .detalle-expand .table-striped > tbody > tr:nth-of-type(2n+1) > td {
        background-color: #f9f9f9; !important;
        padding: 6px;!important;
    }
    .detalle-expand .table-striped > tbody > tr:nth-of-type(2n) > td {
        background-color: #ffffff; !important;
        padding: 6px;!important;
    }
    .detalle-expand .table-striped > thead > tr > th {
        padding-top: 2px; !important;
        padding-left: 6px; !important;
        padding-right: 6px; !important;
        padding-bottom: 2px; !important;
    }
    .detalle-expand .glyphicon {
        /*color: #6cb475;*/
    }
</style>

<div class="detalle-expand" style="padding-left: 20px;padding-right: 20px;">

    <div style="font-size: 16px;padding-top: 4px;padding-bottom: 4px;"><b>SEMANA</b></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'crud-detail',
        'layout' => '{items}',
        'columns' => [
            'id_semana',
            'semana.dia',
            [
                'class' => 'kartik\grid\ActionColumn',
                'vAlign'=>'middle',
                'contentOptions' =>['width'=>'75px', 'style'=>'text-align:center;'],
                'header' => Html::a('Agregar', 'index.php?r=especialidad/adddia&id_maestro='.$id_maestro, [
                    'title' => 'Agregar registro',
                    'class' => 'btn btn-success',
                    'style' => ['width'=>'75px', 'height'=>'30px','padding-top'=>'4px'],
                    'role' => 'modal-remote' ,
                    'onclick' => '$("#ajaxCrudModal .modal-dialog").css({"width":"1000px"})']),

                'template' => '{deleteDetalle}',
                'buttons' => [

                    'deleteDetalle' => function ($url) {
                            return Html::a('<span class="glyphicon glyphicon-trash">&nbsp;</span>', $url,
                                ['role'=>'modal-remote','title'=>'Quitar registro',
                                 'data-url'=> $url,
                                 'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                 'data-request-method'=>'post',
                                 'data-toggle'=>'tooltip',
                                 'data-confirm-title'=>'Quitar Registro',
                                 'data-confirm-message'=>'¿ Desea quitar el registro de esta especialidad ?']);

                        },
                    ],
                    'urlCreator' => function ($action, $searchModel) {
                    // if ($action === 'addAccion') {
                    //     $url ='index.php?r=rol/addrol&idespecialidadrol='.$searchModel->idespecialidadrol;
                    //     return $url;
                    // }
                    if ($action === 'deleteDetalle') {
                        $url ='index.php?r=especialidad/deletedetalle&id_detalle='.$searchModel->id.'&id_maestro='.$searchModel->id_especialidad;
                        return $url;
                    }
                }
            ],
        ],
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
    ]);

    ?>
</div>
