<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
// use johnitvn\ajaxcrud\CrudAsset;
use quidu\ajaxcrud\CrudAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EquipoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Equipos';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div id="w0u" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> EQUIPOS  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/parametrizacion/update','id'=>1], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>
<div class="equipo-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            //Adaptacion para moviles
            'responsiveWrap' => false,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
              ['content'=>
                  Html::button('<i class="glyphicon glyphicon-search"></i>', ['Buscar' ,'title'=> 'Buscar','class'=>'btn btn-default']).
                  Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                  ['role'=>'modal-remote','title'=> 'Crear un equipo','class'=>'btn btn-default']).
                  Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                  ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar'])//.
                  // '{toggleData}'.
                  //  '{export}'
              ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de equipos ',
                'before'=>'<em>* Para buscar algún equipo tipear en el filtro y presionar ENTER o el boton <i class="glyphicon glyphicon-search"></i></em>',

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
