<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
// use johnitvn\ajaxcrud\CrudAsset;
use quidu\ajaxcrud\CrudAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProcedenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procedencias';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<div id="w0proc" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> PROCEDENCIAS  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
</div>
  </div>
<div class="procedencia-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,

            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::button('<i class="glyphicon glyphicon-search"></i>', ['Buscar' ,'title'=> 'Buscar','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Crear nueva plantilla','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar'])
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de procedencias',
                'before'=>'<em>* Para buscar una procedencia, tipear en el filtro y presionar ENTER o el boton <i class="glyphicon glyphicon-search"></i></em>',

                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
